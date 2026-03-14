<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Seance;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Seance::class);

        $enseignant = $this->getEnseignant();

        $seances = Seance::with(['cours', 'promotion'])
            ->whereHas('cours', function ($q) use ($enseignant) {
                $q->where('enseignant_id', $enseignant?->id);
            })
            ->orderByRaw("FIELD(jour, 'lundi','mardi','mercredi','jeudi','vendredi','samedi')")
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour');

        return view('enseignant.emploi_du_temps.liste', compact('seances'));
    }
}

