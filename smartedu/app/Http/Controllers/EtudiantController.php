<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with(['user', 'classe'])->paginate(15);
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        return view('etudiants.create', compact('classes'));
    }

    public function store(StoreEtudiantRequest $request)
    {
        Etudiant::create($request->validated());
        return redirect()->route('etudiants.index')->with('success', 'Étudiant créé avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['user', 'classe', 'notes.evaluation', 'presences.cours', 'paiements']);
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $classes = Classe::orderBy('nom')->get();
        return view('etudiants.edit', compact('etudiant', 'classes'));
    }

    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant)
    {
        $etudiant->update($request->validated());
        return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
