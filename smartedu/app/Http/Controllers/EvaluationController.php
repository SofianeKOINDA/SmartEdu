<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Cours;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with('cours')->paginate(15);
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $cours = Cours::orderBy('titre')->get();
        return view('evaluations.create', compact('cours'));
    }

    public function store(StoreEvaluationRequest $request)
    {
        Evaluation::create($request->validated());
        return redirect()->route('evaluations.index')->with('success', 'Évaluation créée avec succès.');
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['cours', 'notes.etudiant.user']);
        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $cours = Cours::orderBy('titre')->get();
        return view('evaluations.edit', compact('evaluation', 'cours'));
    }

    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $evaluation->update($request->validated());
        return redirect()->route('evaluations.index')->with('success', 'Évaluation mise à jour avec succès.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Évaluation supprimée avec succès.');
    }
}
