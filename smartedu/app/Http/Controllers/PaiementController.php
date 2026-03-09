<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Etudiant;
use App\Models\Cours;
use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['etudiant.user', 'cours'])->paginate(15);
        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $cours = Cours::orderBy('titre')->get();
        return view('paiements.create', compact('etudiants', 'cours'));
    }

    public function store(StorePaiementRequest $request)
    {
        $data = $request->validated();
        if (($data['type'] ?? '') === 'scolarite') {
            $data['cours_id'] = null;
        }
        Paiement::create($data);
        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }

    public function show(Paiement $paiement)
    {
        $paiement->load(['etudiant.user', 'cours']);
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $cours = Cours::orderBy('titre')->get();
        return view('paiements.edit', compact('paiement', 'etudiants', 'cours'));
    }

    public function update(UpdatePaiementRequest $request, Paiement $paiement)
    {
        $data = $request->validated();
        if (($data['type'] ?? '') === 'scolarite') {
            $data['cours_id'] = null;
        }
        $paiement->update($data);
        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}
