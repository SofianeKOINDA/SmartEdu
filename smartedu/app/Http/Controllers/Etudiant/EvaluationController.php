<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Note;

class EvaluationController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $coursIds = $etudiant->cours()->pluck('cours.id');

        $evaluations = Evaluation::with(['cours'])
            ->whereIn('cours_id', $coursIds)
            ->orderByDesc('date_evaluation')
            ->get();

        $notes = Note::where('etudiant_id', $etudiant->id)
            ->whereIn('evaluation_id', $evaluations->pluck('id'))
            ->get()
            ->keyBy('evaluation_id');

        $evaluations->each(function (Evaluation $eval) use ($notes) {
            $eval->maNote = $notes->get($eval->id)?->valeur;
        });

        return view('etudiant.evaluations.liste', compact('evaluations'));
    }
}
