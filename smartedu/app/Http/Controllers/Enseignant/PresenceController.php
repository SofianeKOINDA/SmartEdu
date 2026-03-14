<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresenceRequest;
use App\Http\Requests\UpdatePresenceRequest;
use App\Models\Cours;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function index(Cours $cours)
    {
        $this->authorize('viewAny', Presence::class);

        $etudiants = $cours->etudiants()->with('user')->get();
        $datesSeances = Presence::query()
            ->where('cours_id', $cours->id)
            ->select('date_seance')
            ->distinct()
            ->orderByDesc('date_seance')
            ->pluck('date_seance');

        $presences = Presence::with('etudiant.user')
            ->where('cours_id', $cours->id)
            ->orderByDesc('date_seance')
            ->get()
            ->groupBy(fn (Presence $p) => $p->date_seance?->format('Y-m-d'));

        return view('enseignant.presences.liste', compact('cours', 'etudiants', 'datesSeances', 'presences'));
    }

    public function create(Cours $cours)
    {
        return redirect()->route('enseignant.presences.index', $cours);
    }

    public function store(StorePresenceRequest $request)
    {
        $this->authorize('create', Presence::class);

        $data = array_merge($request->validated(), ['saisi_par' => Auth::id()]);

        Presence::create($data);

        return redirect()->route('enseignant.presences.index', $request->cours_id)
            ->with('success', 'Présence enregistrée.');
    }

    public function update(UpdatePresenceRequest $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $presence->update($request->validated());

        return redirect()->route('enseignant.presences.index', $presence->cours_id)
            ->with('success', 'Présence mise à jour.');
    }
}
