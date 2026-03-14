<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DemandeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Demande::class);

        $demandes = Demande::with(['etudiant.user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('doyen.demandes.index', compact('demandes'));
    }

    public function show(Demande $demande)
    {
        $this->authorize('view', $demande);

        $demande->load(['etudiant.user', 'traitePar']);
        return view('doyen.demandes.show', compact('demande'));
    }

    public function update(Request $request, Demande $demande)
    {
        $this->authorize('update', $demande);

        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,en_cours,traitee,rejetee,annulee'],
            'reponse' => ['nullable', 'string'],
        ]);

        $demande->update([
            'statut' => $data['statut'],
            'reponse' => $data['reponse'] ?? null,
            'traite_par' => Auth::id(),
            'traite_le' => now(),
        ]);

        return redirect()->route('doyen.demandes.show', $demande)->with('success', 'Demande mise à jour.');
    }

    public function download(Demande $demande): Response
    {
        $this->authorize('view', $demande);

        if ($demande->statut !== 'traitee') {
            abort(403, 'Document indisponible.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('doyen.demandes.document', compact('demande'));

        return $pdf->download('demande-' . $demande->id . '.pdf');
    }
}

