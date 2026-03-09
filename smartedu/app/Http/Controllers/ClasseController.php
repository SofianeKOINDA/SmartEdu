<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Cours;
use App\Http\Requests\StoreClasseRequest;
use App\Http\Requests\UpdateClasseRequest;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('etudiants')->with('cours')->latest()->paginate(15);
        $cours   = Cours::orderBy('titre')->get(); // pour le modal d'assignation de cours
        return view('pages.admin.classes', compact('classes', 'cours'));
    }

    public function store(StoreClasseRequest $request)
    {
        Classe::create($request->validated());
        return redirect()->back()->with('success', 'Classe créée avec succès.');
    }

    public function update(UpdateClasseRequest $request, Classe $classe)
    {
        $classe->update($request->validated());
        return redirect()->back()->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->back()->with('success', 'Classe supprimée avec succès.');
    }

    /**
     * Vue détail d'une classe : liste des étudiants + cours assignés.
     */
    public function show(Classe $classe)
    {
        $classe->load(['etudiants.user', 'cours.enseignant.user']);
        return view('pages.admin.classe-detail', compact('classe'));
    }
}
