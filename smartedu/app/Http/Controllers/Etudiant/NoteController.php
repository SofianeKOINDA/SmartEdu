<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $notes = Note::with(['evaluation.cours.ue'])
            ->where('etudiant_id', $etudiant->id)
            ->get()
            ->groupBy(fn($n) => $n->evaluation->cours->ue->nom ?? 'Sans UE');

        $notesParUe = $notes;

        // Moyenne par UE (pondérée par coefficient d’évaluation)
        $moyennesParUe = $notesParUe->map(function ($notesUe) {
            $sumPonderee = $notesUe->sum(fn ($n) => $n->valeur * ($n->evaluation->coefficient ?? 1));
            $sumCoeff    = $notesUe->sum(fn ($n) => $n->evaluation->coefficient ?? 1);
            return $sumCoeff > 0 ? round($sumPonderee / $sumCoeff, 2) : null;
        });

        // Moyenne générale (toutes UE)
        $toutesNotes = $notesParUe->flatten(1);
        $sumPonderee = $toutesNotes->sum(fn ($n) => $n->valeur * ($n->evaluation->coefficient ?? 1));
        $sumCoeff    = $toutesNotes->sum(fn ($n) => $n->evaluation->coefficient ?? 1);
        $moyenneGenerale = $sumCoeff > 0 ? round($sumPonderee / $sumCoeff, 2) : null;

        return view('etudiant.notes.liste', compact('notesParUe', 'moyennesParUe', 'moyenneGenerale'));
    }
}
