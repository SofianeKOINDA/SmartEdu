<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Services\PayTechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayTechController extends Controller
{
    public function __construct(private PayTechService $payTech) {}

    /**
     * Initier le paiement PayTech pour un paiement en attente.
     * Route : GET /etudiant/paiement/{paiement}/pay
     */
    public function initiate(Paiement $paiement)
    {
        // Vérifier que ce paiement appartient bien à l'étudiant connecté
        $etudiant = Auth::user()->etudiant;

        if (!$etudiant || $paiement->etudiant_matricule !== $etudiant->matricule) {
            abort(403, 'Accès refusé.');
        }

        if ($paiement->statut !== 'en_attente') {
            return redirect()->route('etudiant.paiements')
                ->with('error', 'Ce paiement ne peut pas être réglé (statut : ' . $paiement->statut . ').');
        }

        $result = $this->payTech->initiatePayment([
            'item_name'    => 'Paiement ' . ucfirst($paiement->type) . ' — SmartEdu',
            'item_price'   => (int) $paiement->montant,
            'ref_command'  => 'PAY-' . $paiement->id . '-' . time(),
            'command_name' => 'Paiement SmartEdu #' . $paiement->id,
            'ipn_url'      => route('paytech.ipn'),
            'success_url'  => route('paytech.success', $paiement->id),
            'cancel_url'   => route('paytech.cancel', $paiement->id),
            'custom_field' => ['paiement_id' => $paiement->id],
        ]);

        if (!$result['success']) {
            return redirect()->route('etudiant.paiements')
                ->with('error', 'Erreur PayTech : ' . $result['error']);
        }

        // Sauvegarder le token PayTech sur le paiement
        $paiement->update(['paytech_token' => $result['token'] ?? null]);

        return redirect($result['redirect_url']);
    }

    /**
     * Callback IPN (webhook) PayTech — appelé par les serveurs PayTech.
     * Route : POST /paytech/ipn
     */
    public function ipn(Request $request)
    {
        // Vérification de la signature PayTech
        $apiKey    = config('paytech.api_key');
        $apiSecret = config('paytech.api_secret');

        $receivedHash = $request->header('API_KEY_SHA256')
                     ?? $request->input('api_key_sha256');
        $expectedHash = hash('sha256', $apiKey . $apiSecret);

        if ($receivedHash !== $expectedHash) {
            Log::warning('PayTech IPN : signature invalide', $request->all());
            return response('INVALID_SIGNATURE', 403);
        }

        // Récupérer le paiement via custom_field
        $customField = json_decode($request->input('custom_field', '{}'), true);
        $paiementId  = $customField['paiement_id'] ?? null;

        if (!$paiementId) {
            Log::error('PayTech IPN : paiement_id manquant', $request->all());
            return response('MISSING_PAIEMENT_ID', 400);
        }

        $paiement = Paiement::find($paiementId);

        if (!$paiement) {
            Log::error('PayTech IPN : paiement introuvable', ['id' => $paiementId]);
            return response('PAIEMENT_NOT_FOUND', 404);
        }

        // Mettre à jour le statut
        $paiement->update([
            'statut'  => 'valide',
            'methode' => $this->mapMethode($request->input('payment_method', '')),
        ]);

        Log::info('PayTech IPN : paiement validé', ['paiement_id' => $paiementId]);

        return response('OK', 200);
    }

    /**
     * Redirection après paiement réussi.
     * Route : GET /paytech/success/{paiement}
     */
    public function success(Paiement $paiement)
    {
        return redirect()->route('etudiant.paiements')
            ->with('success', 'Paiement de ' . number_format($paiement->montant, 0, ',', ' ') . ' FCFA effectué avec succès !');
    }

    /**
     * Redirection après annulation.
     * Route : GET /paytech/cancel/{paiement}
     */
    public function cancel(Paiement $paiement)
    {
        return redirect()->route('etudiant.paiements')
            ->with('error', 'Paiement annulé.');
    }

    /**
     * Convertit la méthode PayTech en valeur de notre enum.
     */
    private function mapMethode(string $payMethod): string
    {
        return match(strtolower($payMethod)) {
            'orange money', 'orange_money' => 'mobile_money',
            'wave'                          => 'mobile_money',
            'free money', 'free_money'      => 'mobile_money',
            'visa', 'mastercard', 'card'    => 'carte',
            'virement', 'bank_transfer'     => 'virement',
            default                         => 'mobile_money',
        };
    }
}
