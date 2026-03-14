<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Cours;

class CoursController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $cours = $etudiant->cours()
            ->with(['ue.semestre', 'enseignant.user', 'evaluations'])
            ->get();

        return view('etudiant.cours.liste', compact('cours'));
    }

    public function show(Cours $cours)
    {
        $this->authorize('view', $cours);

        $cours->load(['ue.semestre', 'enseignant.user', 'evaluations']);

        return view('etudiant.cours.show', compact('cours'));
    }
}
