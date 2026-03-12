<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Evaluation;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(Evaluation $evaluation)
    {
        $this->authorize('viewAny', Note::class);

        $notes = Note::with('etudiant.user')
            ->where('evaluation_id', $evaluation->id)
            ->paginate(50);

        return view('enseignant.notes.index', compact('evaluation', 'notes'));
    }

    public function create(Evaluation $evaluation)
    {
        $this->authorize('create', Note::class);

        $etudiants = $evaluation->cours->etudiants()->with('user')->get();

        return view('enseignant.notes.create', compact('evaluation', 'etudiants'));
    }

    public function store(StoreNoteRequest $request)
    {
        $this->authorize('create', Note::class);

        $data = array_merge($request->validated(), ['saisi_par' => auth()->id()]);

        Note::create($data);

        return redirect()->route('enseignant.evaluations.index', $request->evaluation_id)
            ->with('success', 'Note enregistrée.');
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $note->update($request->validated());

        return back()->with('success', 'Note mise à jour.');
    }
}
