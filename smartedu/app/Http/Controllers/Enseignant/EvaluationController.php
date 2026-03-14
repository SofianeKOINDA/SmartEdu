<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Cours;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index(Cours $cours)
    {
        $this->authorize('viewAny', Evaluation::class);

        $evaluations = Evaluation::where('cours_id', $cours->id)->orderByDesc('created_at')->get();

        return view('enseignant.evaluations.liste', compact('cours', 'evaluations'));
    }

    public function create(Cours $cours)
    {
        return redirect()->route('enseignant.evaluations.index', $cours);
    }

    public function store(StoreEvaluationRequest $request)
    {
        $this->authorize('create', Evaluation::class);

        Evaluation::create($request->validated());

        return redirect()->route('enseignant.evaluations.index', $request->cours_id)
            ->with('success', 'Évaluation créée.');
    }

    public function edit(Evaluation $evaluation)
    {
        return redirect()->route('enseignant.evaluations.index', $evaluation->cours_id);
    }

    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $this->authorize('update', $evaluation);

        $evaluation->update($request->validated());

        return redirect()->route('enseignant.evaluations.index', $evaluation->cours_id)
            ->with('success', 'Évaluation mise à jour.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $this->authorize('delete', $evaluation);

        $coursId = $evaluation->cours_id;
        $evaluation->delete();

        return redirect()->route('enseignant.evaluations.index', $coursId)
            ->with('success', 'Évaluation supprimée.');
    }
}
