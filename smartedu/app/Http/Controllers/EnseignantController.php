<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::with('user')->paginate(15);
        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('enseignants.create');
    }

    public function store(StoreEnseignantRequest $request)
    {
        Enseignant::create($request->validated());
        return redirect()->route('enseignants.index')->with('success', 'Enseignant créé avec succès.');
    }

    public function show(Enseignant $enseignant)
    {
        $enseignant->load(['user', 'cours']);
        return view('enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(UpdateEnseignantRequest $request, Enseignant $enseignant)
    {
        $enseignant->update($request->validated());
        return redirect()->route('enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
