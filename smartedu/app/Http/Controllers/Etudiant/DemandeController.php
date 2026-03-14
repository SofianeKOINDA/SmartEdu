<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemandeController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $demandes = Demande::where('etudiant_id', $etudiant->id)
            ->orderByDesc('created_at')
            ->get();

        return view('etudiant.demandes.liste', compact('demandes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'  => ['required', 'in:attestation,releve_notes,certificat,autre'],
            'motif' => ['nullable', 'string', 'max:500'],
        ]);

        $etudiant = $this->getEtudiant();

        Demande::create([
            'tenant_id'   => $this->getTenantId(),
            'etudiant_id' => $etudiant->id,
            'type'        => $data['type'],
            'motif'       => $data['motif'] ?? null,
            'statut'      => 'en_attente',
        ]);

        return redirect()->route('etudiant.demandes.index')
            ->with('success', 'Demande soumise avec succès.');
    }

    public function destroy(Demande $demande)
    {
        $this->authorize('annuler', $demande);

        $demande->delete();

        return redirect()->route('etudiant.demandes.index')
            ->with('success', 'Demande annulée.');
    }

    public function download(Demande $demande): Response
    {
        $this->authorize('view', $demande);

        if ($demande->statut !== 'traitee') {
            abort(403, 'Document indisponible.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('etudiant.demandes.document', compact('demande'));

        $filename = 'demande-' . $demande->id . '.pdf';
        return $pdf->download($filename);
    }
}
