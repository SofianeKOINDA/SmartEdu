<?php

namespace App\Services;

use App\Models\Echeance;
use App\Models\Etudiant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PayTechService
{
    private string $apiKey;
    private string $apiSecret;
    private string $env;
    private string $baseUrl = 'https://paytech.sn/api';

    public function __construct()
    {
        $this->apiKey    = config('services.paytech.api_key', '');
        $this->apiSecret = config('services.paytech.api_secret', '');
        $this->env       = config('services.paytech.env', 'test');
    }

    /**
     * Initie un paiement PayTech pour une échéance et redirige l'étudiant.
     */
    public function initierPaiement(Echeance $echeance, Etudiant $etudiant): string
    {
        $reference = 'ECH-' . $echeance->id . '-' . Str::upper(Str::random(8));

        $transaction = Transaction::create([
            'tenant_id'   => $echeance->tenant_id,
            'echeance_id' => $echeance->id,
            'etudiant_id' => $etudiant->id,
            'reference'   => $reference,
            'montant'     => $echeance->montant,
            'statut'      => 'initie',
        ]);

        $payload = [
            'item_name'        => 'Echéance ' . $echeance->numero_mois,
            'item_price'       => (int) ($echeance->montant * 100),
            'currency'         => 'XOF',
            'ref_command'      => $reference,
            'command_name'     => 'Paiement scolarité - Mois ' . $echeance->numero_mois,
            'env'              => $this->env,
            'ipn_url'          => route('webhooks.paytech'),
            'success_url'      => route('etudiant.echeances.index'),
            'cancel_url'       => route('etudiant.echeances.index'),
        ];

        $response = Http::withHeaders([
            'API_KEY'    => $this->apiKey,
            'API_SECRET' => $this->apiSecret,
        ])->post($this->baseUrl . '/payment/request-payment', $payload);

        if ($response->successful() && isset($response->json()['redirect_url'])) {
            $redirectUrl = $response->json()['redirect_url'];
            $token = $response->json()['token'] ?? null;

            $transaction->update(['paytech_token' => $token]);

            return $redirectUrl;
        }

        $transaction->update(['statut' => 'echec']);

        throw new \RuntimeException('PayTech : impossible d\'initier le paiement. ' . $response->body());
    }

    /**
     * Traite le webhook PayTech et marque l'échéance comme payée.
     * C'est la seule source de vérité pour confirmer un paiement.
     */
    public function traiterWebhook(Request $request): void
    {
        $refCommand = $request->input('ref_command');
        $paytechRef = $request->input('paytech_ref');
        $typeEvent  = $request->input('type_event');

        if ($typeEvent !== 'sale_complete') {
            return;
        }

        $transaction = Transaction::withoutGlobalScope('tenant')
            ->where('reference', $refCommand)
            ->first();

        if ($transaction === null || $transaction->statut === 'succes') {
            return;
        }

        DB::transaction(function () use ($transaction, $paytechRef) {
            $transaction->update([
                'statut'      => 'succes',
                'paytech_ref' => $paytechRef,
                'paye_le'     => now(),
            ]);

            $transaction->echeance->update(['statut' => 'paye']);
        });
    }
}
