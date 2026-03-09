<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['etudiant.user', 'evaluation.cours'])->paginate(15);
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $evaluations = Evaluation::with('cours')->orderBy('date_limite', 'desc')->get();
        return view('notes.create', compact('etudiants', 'evaluations'));
    }

    public function store(StoreNoteRequest $request)
    {
        Note::create($request->validated());
        return redirect()->route('notes.index')->with('success', 'Note enregistrée avec succès.');
    }

    public function show(Note $note)
    {
        $note->load(['etudiant.user', 'evaluation.cours']);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        $evaluations = Evaluation::with('cours')->orderBy('date_limite', 'desc')->get();
        return view('notes.edit', compact('note', 'etudiants', 'evaluations'));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès.');
    }
}
