<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Seance;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Seance::class);

        $etudiant = auth()->user()->etudiant;

        $seances = Seance::with(['cours.enseignant.user'])
            ->where('promotion_id', $etudiant?->promotion_id)
            ->orderByRaw("FIELD(jour, 'lundi','mardi','mercredi','jeudi','vendredi','samedi')")
            ->orderBy('heure_debut')
            ->get();

        return view('etudiant.emploi_du_temps.index', compact('seances'));
    }
}
