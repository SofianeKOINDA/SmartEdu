<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Echeance;
use App\Services\PayTechService;
use Illuminate\Http\RedirectResponse;

class EcheanceController extends Controller
{
    public function __construct(private PayTechService $payTechService) {}

    public function index()
    {
        $this->authorize('viewAny', Echeance::class);

        $etudiant = auth()->user()->etudiant;

        $echeances = Echeance::with('tarif.anneeScolaire')
            ->where('etudiant_id', $etudiant->id)
            ->orderBy('numero_mois')
            ->get();

        return view('etudiant.echeances.index', compact('echeances'));
    }

    public function payer(Echeance $echeance): RedirectResponse
    {
        $this->authorize('payer', $echeance);

        $etudiant = auth()->user()->etudiant;

        $redirectUrl = $this->payTechService->initierPaiement($echeance, $etudiant);

        return redirect()->away($redirectUrl);
    }
}
