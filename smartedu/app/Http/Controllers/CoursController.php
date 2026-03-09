<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;

class CoursController extends Controller
{
    public function index()
    {
        $cours      = Cours::with('enseignant.user')->withCount(['evaluations', 'presences'])->latest()->paginate(15);
        $enseignants = Enseignant::with('user')->orderBy('matricule_enseignant')->get();
        $classes     = Classe::orderBy('nom')->get();
        return view('pages.admin.cours', compact('cours', 'enseignants', 'classes'));
    }

    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->validated());

        if ($request->filled('classes') && is_array($request->classes)) {
            $cours->classes()->sync($request->classes);
        }

        return redirect()->back()->with('success', 'Cours créé avec succès.');
    }

    public function update(UpdateCoursRequest $request, Cours $cours)
    {
        $cours->update($request->validated());

        if ($request->has('classes')) {
            $cours->classes()->sync($request->classes ?? []);
        }

        return redirect()->back()->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy(Cours $cours)
    {
        $cours->delete();
        return redirect()->back()->with('success', 'Cours supprimé avec succès.');
    }

    /**
     * Détail d'un cours : étudiants, évaluations, présences.
     */
    public function show(Cours $cours)
    {
        $cours->load(['enseignant.user', 'classes.etudiants.user', 'evaluations.notes', 'presences.etudiant.user']);
        return view('pages.enseignant.cours-detail', compact('cours'));
    }
}
