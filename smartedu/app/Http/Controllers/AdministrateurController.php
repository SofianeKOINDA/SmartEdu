<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use App\Http\Requests\StoreAdministrateurRequest;
use App\Http\Requests\UpdateAdministrateurRequest;

class AdministrateurController extends Controller
{
    public function index()
    {
        $administrateurs = Administrateur::with('user')->paginate(15);
        return view('administrateurs.index', compact('administrateurs'));
    }

    public function create()
    {
        return view('administrateurs.create');
    }

    public function store(StoreAdministrateurRequest $request)
    {
        Administrateur::create($request->validated());
        return redirect()->route('administrateurs.index')->with('success', 'Administrateur créé avec succès.');
    }

    public function show(Administrateur $administrateur)
    {
        $administrateur->load('user');
        return view('administrateurs.show', compact('administrateur'));
    }

    public function edit(Administrateur $administrateur)
    {
        return view('administrateurs.edit', compact('administrateur'));
    }

    public function update(UpdateAdministrateurRequest $request, Administrateur $administrateur)
    {
        $administrateur->update($request->validated());
        return redirect()->route('administrateurs.index')->with('success', 'Administrateur mis à jour avec succès.');
    }

    public function destroy(Administrateur $administrateur)
    {
        $administrateur->delete();
        return redirect()->route('administrateurs.index')->with('success', 'Administrateur supprimé avec succès.');
    }
}
