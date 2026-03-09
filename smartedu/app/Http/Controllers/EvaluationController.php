<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use App\Models\Cours;
use App\Models\Etudiant;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;

class EvaluationController extends Controller
{
    /**
     * Liste des évaluations — enseignant voit les siennes, admin voit tout.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'enseignant') {
            $coursIds    = $user->enseignant->cours()->pluck('id');
            $evaluations = Evaluation::whereIn('cours_id', $coursIds)
                ->with('cours')
                ->latest('date_limite')
                ->paginate(15);
            $cours = Cours::whereIn('id', $coursIds)->orderBy('titre')->get();
        } else {
            $evaluations = Evaluation::with('cours.enseignant.user')
                ->latest('date_limite')
                ->paginate(15);
            $cours = Cours::orderBy('titre')->get();
        }

        return view('pages.enseignant.evaluations', compact('evaluations', 'cours'));
    }

    /**
     * Créer une évaluation via modal.
     */
    public function store(StoreEvaluationRequest $request)
    {
        Evaluation::create($request->validated());
        return redirect()->back()->with('success', 'Évaluation créée avec succès.');
    }

    /**
     * Mettre à jour une évaluation via modal.
     */
    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $evaluation->update($request->validated());
        return redirect()->back()->with('success', 'Évaluation mise à jour avec succès.');
    }

    /**
     * Supprimer une évaluation via modal.
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->back()->with('success', 'Évaluation supprimée avec succès.');
    }

    /**
     * Détail d'une évaluation : liste des notes par étudiant.
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['cours.classes.etudiants.user', 'notes.etudiant.user']);

        // Étudiants de la classe du cours, pour le modal d'attribution de note
        $etudiants = Etudiant::whereIn('classe_id', $evaluation->cours->classes->pluck('id'))
            ->with('user')
            ->orderBy('matricule')
            ->get();

        return view('pages.enseignant.evaluation-detail', compact('evaluation', 'etudiants'));
    }
}
