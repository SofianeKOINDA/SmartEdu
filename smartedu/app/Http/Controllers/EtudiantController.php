<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use App\Models\Evaluation;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    /**
     * Dashboard de l'étudiant connecté :
     * ses notes, évaluations à venir, présences, paiements.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || !$user->etudiant) {
            abort(403, 'Accès réservé aux étudiants connectés.');
        }

        $etudiant = $user->etudiant;

        $notes = $etudiant->notes()
            ->with('evaluation.cours')
            ->latest()
            ->get();

        $evaluations = Evaluation::whereHas('cours.classes', function ($q) use ($etudiant) {
                $q->where('classes.id', $etudiant->classe_id);
            })
            ->where('date_limite', '>=', now())
            ->orderBy('date_limite')
            ->get();

        $presences = $etudiant->presences()
            ->with('cours')
            ->orderBy('date', 'desc')
            ->get();

        $paiements = $etudiant->paiements()
            ->orderBy('date', 'desc')
            ->get();

        return view('etudiant', compact(
            'etudiant', 'notes', 'evaluations', 'presences', 'paiements'
        ));
    }

    /**
     * L'étudiant met à jour son profil (nom, prenom, photo).
     */
    public function updateProfil(Request $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            abort(403, 'Vous devez être connecté.');
        }

        $request->validate([
            'nom'          => ['required', 'string', 'max:100'],
            'prenom'       => ['required', 'string', 'max:100'],
            'photo_profil' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
        ];

        if ($request->hasFile('photo_profil')) {
            $data['photo_profil'] = $request->file('photo_profil')->store('profils', 'public');
        }

        \App\Models\User::where('id', $userId)->update($data);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    //  Admin : gestion des étudiants 

    /**
     * Liste de tous les étudiants (vue admin).
     */
    public function index()
    {
        $etudiants = Etudiant::with(['user', 'classe'])->latest()->paginate(15);
        $classes   = Classe::orderBy('nom')->get();

        return view('pages.admin.Etudiant.liste', compact('etudiants', 'classes'));
    }

    /**
     * Créer un étudiant (User + Etudiant) via modal.
     */
    public function store(StoreEtudiantRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'nom'      => $request->nom,
                'prenom'   => $request->prenom,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'etudiant',
            ]);

            Etudiant::create([
                'user_id'        => $user->id,
                'matricule'      => $request->matricule,
                'date_naissance' => $request->date_naissance,
                'classe_id'      => $request->classe_id,
            ]);
        });

        return redirect()->back()->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Mettre à jour un étudiant via modal.
     */
    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant)
    {
        DB::transaction(function () use ($request, $etudiant) {
            $userFields = array_filter([
                'nom'    => $request->nom,
                'prenom' => $request->prenom,
                'email'  => $request->email,
            ], fn($v) => !is_null($v));

            if ($request->filled('password')) {
                $userFields['password'] = Hash::make($request->password);
            }

            $etudiant->user->update($userFields);

            $etudiant->update($request->only([
                'matricule', 'date_naissance', 'classe_id',
            ]));
        });

        return redirect()->back()->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Supprimer un étudiant (et son user) via modal.
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->user->delete(); // cascade supprime l'étudiant
        return redirect()->back()->with('success', 'Étudiant supprimé avec succès.');
    }
}
