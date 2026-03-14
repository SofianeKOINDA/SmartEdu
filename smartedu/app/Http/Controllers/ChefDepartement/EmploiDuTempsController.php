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

        $promotions = Promotion::with(['seances.cours.enseignant.user'])->get();

        $seancesParPromotion = $promotions->keyBy('id')->map(fn($p) => $p->seances);

        return view('chef_departement.emploi_du_temps.liste', compact('promotions', 'seancesParPromotion'));
    }

    public function show(Promotion $promotion)
    {
        return redirect()->route('chef_departement.emploi_du_temps.index');
    }
}
