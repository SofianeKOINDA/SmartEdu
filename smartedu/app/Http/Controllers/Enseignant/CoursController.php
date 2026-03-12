<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cours::class);

        $enseignant = auth()->user()->enseignant;

        $cours = Cours::with(['ue.semestre', 'evaluations'])
            ->where('enseignant_id', $enseignant?->id)
            ->paginate(20);

        return view('enseignant.cours.index', compact('cours'));
    }

    public function show(Cours $cours)
    {
        $this->authorize('view', $cours);

        $cours->load(['etudiants.user', 'evaluations.notes', 'presences']);

        return view('enseignant.cours.show', compact('cours'));
    }
}
