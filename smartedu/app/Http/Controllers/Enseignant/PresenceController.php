<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresenceRequest;
use App\Http\Requests\UpdatePresenceRequest;
use App\Models\Cours;
use App\Models\Presence;

class PresenceController extends Controller
{
    public function index(Cours $cours)
    {
        $this->authorize('viewAny', Presence::class);

        $presences = Presence::with('etudiant.user')
            ->where('cours_id', $cours->id)
            ->orderBy('date_seance', 'desc')
            ->paginate(30);

        return view('enseignant.presences.index', compact('cours', 'presences'));
    }

    public function create(Cours $cours)
    {
        $this->authorize('create', Presence::class);

        $etudiants = $cours->etudiants()->with('user')->get();

        return view('enseignant.presences.create', compact('cours', 'etudiants'));
    }

    public function store(StorePresenceRequest $request)
    {
        $this->authorize('create', Presence::class);

        $data = array_merge($request->validated(), ['saisi_par' => auth()->id()]);

        Presence::create($data);

        return redirect()->route('enseignant.cours.show', $request->cours_id)
            ->with('success', 'Présence enregistrée.');
    }

    public function update(UpdatePresenceRequest $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $presence->update($request->validated());

        return back()->with('success', 'Présence mise à jour.');
    }
}
