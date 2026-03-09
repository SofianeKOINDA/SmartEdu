<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Enseignant;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with('enseignant.user')->paginate(15);
        return view('cours.index', compact('cours'));
    }

    public function create()
    {
        $enseignants = Enseignant::with('user')->orderBy('id')->get();
        return view('cours.create', compact('enseignants'));
    }

    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->validated());
        if ($request->has('classes') && is_array($request->classes)) {
            $cours->classes()->sync($request->classes);
        }
        return redirect()->route('cours.index')->with('success', 'Cours créé avec succès.');
    }

    public function show(Cours $cours)
    {
        $cours->load(['enseignant.user', 'classes', 'evaluations', 'presences.etudiant']);
        return view('cours.show', compact('cours'));
    }

    public function edit(Cours $cours)
    {
        $enseignants = Enseignant::with('user')->orderBy('id')->get();
        $cours->load('classes');
        return view('cours.edit', compact('cours', 'enseignants'));
    }

    public function update(UpdateCoursRequest $request, Cours $cours)
    {
        $cours->update($request->validated());
        if ($request->has('classes')) {
            $cours->classes()->sync($request->classes ?? []);
        }
        return redirect()->route('cours.index')->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy(Cours $cours)
    {
        $cours->delete();
        return redirect()->route('cours.index')->with('success', 'Cours supprimé avec succès.');
    }
}
