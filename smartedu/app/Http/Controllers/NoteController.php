<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Evaluation;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Liste des notes — enseignant voit les siennes, admin voit tout.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'enseignant') {
            $coursIds      = $user->enseignant->cours()->pluck('id');
            $evaluationIds = Evaluation::whereIn('cours_id', $coursIds)->pluck('id');
            $notes = Note::whereIn('evaluation_id', $evaluationIds)
                ->with(['etudiant.user', 'evaluation.cours'])
                ->latest()
                ->paginate(20);
        } else {
            $notes = Note::with(['etudiant.user', 'evaluation.cours'])
                ->latest()
                ->paginate(20);
        }

        $evaluations = Evaluation::with('cours')->orderBy('titre')->get();

        return view('pages.enseignant.notes', compact('notes', 'evaluations'));
    }

    /**
     * Attribuer une note via modal.
     */
    public function store(StoreNoteRequest $request)
    {
        Note::create($request->validated());
        return redirect()->back()->with('success', 'Note enregistrée avec succès.');
    }

    /**
     * Modifier une note via modal.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        return redirect()->back()->with('success', 'Note mise à jour avec succès.');
    }

    /**
     * Supprimer une note via modal.
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->back()->with('success', 'Note supprimée avec succès.');
    }
}
