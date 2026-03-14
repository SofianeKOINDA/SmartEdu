<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cours::class);

        $enseignant = $this->getEnseignant();

        $cours = Cours::with(['ue.semestre', 'evaluations'])
            ->where('enseignant_id', $enseignant?->id)
            ->get();

        return view('enseignant.cours.liste', compact('cours'));
    }

    public function show(Cours $cours)
    {
        $this->authorize('view', $cours);

        $cours->load(['etudiants.user', 'evaluations.notes', 'presences']);

        return view('enseignant.cours.show', compact('cours'));
    }
}
