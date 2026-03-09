<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Etudiant;
use App\Models\Cours;
use App\Http\Requests\StorePresenceRequest;
use App\Http\Requests\UpdatePresenceRequest;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::with(['etudiant.user', 'cours'])->paginate(15);
        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $cours = Cours::orderBy('titre')->get();
        return view('presences.create', compact('etudiants', 'cours'));
    }

    public function store(StorePresenceRequest $request)
    {
        Presence::create($request->validated());
        return redirect()->route('presences.index')->with('success', 'Présence enregistrée avec succès.');
    }

    public function show(Presence $presence)
    {
        $presence->load(['etudiant.user', 'cours']);
        return view('presences.show', compact('presence'));
    }

    public function edit(Presence $presence)
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $cours = Cours::orderBy('titre')->get();
        return view('presences.edit', compact('presence', 'etudiants', 'cours'));
    }

    public function update(UpdatePresenceRequest $request, Presence $presence)
    {
        $presence->update($request->validated());
        return redirect()->route('presences.index')->with('success', 'Présence mise à jour avec succès.');
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Présence supprimée avec succès.');
    }
}
