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

        $etudiant = $user->etudiant()->with([
            'classe.cours' => fn($q) => $q->with(['enseignant.user'])->withCount('evaluations'),
        ])->first();

        $notes = $etudiant->notes()
            ->with('evaluation.cours')
            ->latest()
            ->get();

        $evaluations = Evaluation::whereHas('cours.classes', function ($q) use ($etudiant) {
                $q->where('classes.id', $etudiant->classe_id);
            })
            ->with('cours')
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

    // ─── Pages dédiées étudiant ───────────────────────────────────────────────

    public function mesNotes()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) abort(403);
        $notes = $etudiant->notes()->with('evaluation.cours')->latest()->get();
        return view('pages.etudiant.Note.liste', compact('etudiant', 'notes'));
    }

    public function mesCours()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) abort(403);
        $cours = $etudiant->classe
            ? $etudiant->classe->cours()->with(['enseignant.user'])->withCount('evaluations')->get()
            : collect();
        return view('pages.etudiant.Cours.liste', compact('etudiant', 'cours'));
    }

    public function mesPresences()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) abort(403);
        $presences = $etudiant->presences()->with('cours')->orderBy('date', 'desc')->get();
        return view('pages.etudiant.Presence.liste', compact('etudiant', 'presences'));
    }

    public function mesPaiements()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) abort(403);
        $paiements = $etudiant->paiements()->orderBy('date', 'desc')->get();
        return view('pages.etudiant.Paiement.liste', compact('etudiant', 'paiements'));
    }

    public function maClasse()
    {
        $etudiant = Auth::user()->etudiant;
        if (!$etudiant) abort(403);
        $classe = $etudiant->classe
            ? $etudiant->classe->load(['etudiants.user', 'cours.enseignant.user'])
            : null;
        return view('pages.etudiant.Classe.liste', compact('etudiant', 'classe'));
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
