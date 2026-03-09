<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\Presence;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    /**
     * Dashboard de l'enseignant connecté :
     * ses cours, classes, évaluations, notes récentes, présences récentes.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || !$user->enseignant) {
            abort(403, 'Accès réservé aux enseignants connectés.');
        }

        $enseignant = $user->enseignant;

        $cours = $enseignant->cours()
            ->with('classes')
            ->withCount(['evaluations', 'presences'])
            ->get();

        $coursIds = $cours->pluck('id');

        $classes = $cours->flatMap->classes->unique('id');

        $evaluations = Evaluation::whereIn('cours_id', $coursIds)
            ->with('cours')
            ->orderBy('date_limite')
            ->get();

        $notesRecentes = Note::whereIn('evaluation_id', $evaluations->pluck('id'))
            ->with(['etudiant.user', 'evaluation'])
            ->latest()
            ->take(20)
            ->get();

        $presencesRecentes = Presence::whereIn('cours_id', $coursIds)
            ->with(['etudiant.user', 'cours'])
            ->orderBy('date', 'desc')
            ->take(20)
            ->get();

        // Étudiants de toutes ses classes
        $classeIds = $classes->pluck('id');
        $etudiants = Etudiant::whereIn('classe_id', $classeIds)
            ->with(['user', 'classe'])
            ->get();

        return view('enseignant', compact(
            'enseignant', 'cours', 'classes', 'evaluations',
            'notesRecentes', 'presencesRecentes', 'etudiants'
        ));
    }

    // ─── Admin : gestion des enseignants ─────────────────────────────────────

    /**
     * Liste de tous les enseignants (vue admin).
     */
    public function index()
    {
        $enseignants = Enseignant::with(['user', 'cours'])->latest()->paginate(15);
        return view('pages.admin.Enseignant.liste', compact('enseignants'));
    }

    /**
     * Créer un enseignant (User + Enseignant) via modal.
     */
    public function store(StoreEnseignantRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'nom'      => $request->nom,
                'prenom'   => $request->prenom,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'enseignant',
            ]);

            Enseignant::create([
                'user_id'              => $user->id,
                'specialite'           => $request->specialite,
                'telephone'            => $request->telephone,
                'matricule_enseignant' => $request->matricule_enseignant,
            ]);
        });

        return redirect()->back()->with('success', 'Enseignant créé avec succès.');
    }

    /**
     * Mettre à jour un enseignant via modal.
     */
    public function update(UpdateEnseignantRequest $request, Enseignant $enseignant)
    {
        DB::transaction(function () use ($request, $enseignant) {
            $userFields = array_filter([
                'nom'    => $request->nom,
                'prenom' => $request->prenom,
                'email'  => $request->email,
            ], fn($v) => !is_null($v));

            if ($request->filled('password')) {
                $userFields['password'] = Hash::make($request->password);
            }

            $enseignant->user->update($userFields);

            $enseignant->update($request->only([
                'specialite', 'telephone', 'matricule_enseignant',
            ]));
        });

        return redirect()->back()->with('success', 'Enseignant mis à jour avec succès.');
    }

    /**
     * Supprimer un enseignant (et son user) via modal.
     */
    public function destroy(Enseignant $enseignant)
    {
        $enseignant->user->delete(); // cascade supprime l'enseignant
        return redirect()->back()->with('success', 'Enseignant supprimé avec succès.');
    }
}
