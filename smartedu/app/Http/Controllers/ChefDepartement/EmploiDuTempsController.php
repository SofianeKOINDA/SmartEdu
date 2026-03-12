<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Seance;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Seance::class);

        $promotions = Promotion::with([
            'seances.cours.enseignant.user',
        ])->get();

        return view('chef_departement.emploi_du_temps.index', compact('promotions'));
    }

    public function show(Promotion $promotion)
    {
        $this->authorize('view', $promotion);

        $seances = Seance::with(['cours.enseignant.user'])
            ->where('promotion_id', $promotion->id)
            ->orderByRaw("FIELD(jour, 'lundi','mardi','mercredi','jeudi','vendredi','samedi')")
            ->orderBy('heure_debut')
            ->get();

        return view('chef_departement.emploi_du_temps.show', compact('promotion', 'seances'));
    }
}
