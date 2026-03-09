<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Http\Requests\StoreClasseRequest;
use App\Http\Requests\UpdateClasseRequest;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('etudiants')->paginate(15);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(StoreClasseRequest $request)
    {
        Classe::create($request->validated());
        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    public function show(Classe $classe)
    {
        $classe->load(['etudiants.user', 'cours']);
        return view('classes.show', compact('classe'));
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(UpdateClasseRequest $request, Classe $classe)
    {
        $classe->update($request->validated());
        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
