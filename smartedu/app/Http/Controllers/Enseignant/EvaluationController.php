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

        $evaluations = Evaluation::where('cours_id', $cours->id)->paginate(20);

        return view('enseignant.evaluations.index', compact('cours', 'evaluations'));
    }

    public function create(Cours $cours)
    {
        $this->authorize('create', Evaluation::class);

        return view('enseignant.evaluations.create', compact('cours'));
    }

    public function store(StoreEvaluationRequest $request)
    {
        $this->authorize('create', Evaluation::class);

        Evaluation::create($request->validated());

        return redirect()->route('enseignant.cours.show', $request->cours_id)
            ->with('success', 'Évaluation créée.');
    }

    public function edit(Evaluation $evaluation)
    {
        $this->authorize('update', $evaluation);

        return view('enseignant.evaluations.edit', compact('evaluation'));
    }

    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $this->authorize('update', $evaluation);

        $evaluation->update($request->validated());

        return back()->with('success', 'Évaluation mise à jour.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $this->authorize('delete', $evaluation);

        $evaluation->delete();

        return back()->with('success', 'Évaluation supprimée.');
    }
}
