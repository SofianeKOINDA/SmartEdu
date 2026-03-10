<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\Presence;
use App\Http\Requests\StoreEnseignantRequest;
use App\Http\Requests\UpdateEnseignantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    /**
     * Dashboard de l'enseignant connecté.
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

        $classeIds = $classes->pluck('id');
        $etudiants = Etudiant::whereIn('classe_id', $classeIds)
            ->with(['user', 'classe'])
            ->get();

        return view('enseignant', compact(
            'enseignant', 'cours', 'classes', 'evaluations',
            'notesRecentes', 'presencesRecentes', 'etudiants'
        ));
    }

    /**
     * L'enseignant met à jour son profil.
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nom'          => ['required', 'string', 'max:100'],
            'prenom'       => ['required', 'string', 'max:100'],
            'photo_profil' => ['nullable', 'image', 'max:5048'],
        ]);

        $data = ['nom' => $request->nom, 'prenom' => $request->prenom];

        if ($request->hasFile('photo_profil')) {
            $data['photo_profil'] = $request->file('photo_profil')->store('profils', 'public');
        }

        \App\Models\User::where('id', Auth::id())->update($data);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    // ─── Pages dédiées enseignant ──────────────────────────────────────────────

    public function mesCours()
    {
        $enseignant    = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $cours         = $enseignant->cours()
            ->with(['classes'])
            ->withCount(['evaluations', 'presences'])
            ->get();

        $toutesClasses = Classe::orderBy('nom')->get();

        return view('pages.enseignant.Cours.liste', compact('enseignant', 'cours', 'toutesClasses'));
    }

    /**
     * Synchronise les classes associées à un cours de l'enseignant.
     */
    public function syncClasses(Request $request, Cours $cours)
    {
        $enseignant = Auth::user()->enseignant;
        if ($cours->enseignant_matricule !== $enseignant->matricule_enseignant) {
            abort(403);
        }

        $cours->classes()->sync($request->input('classe_ids', []));

        return redirect()->back()->with('success', 'Classes du cours mises à jour.');
    }

    public function mesEvaluations()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $coursIds   = $enseignant->cours()->pluck('id');
        $evaluations = Evaluation::whereIn('cours_id', $coursIds)
            ->with('cours')
            ->orderBy('date_limite')
            ->get();
        $cours = $enseignant->cours()->get();

        return view('pages.enseignant.Evaluation.liste', compact('enseignant', 'evaluations', 'cours'));
    }

    public function mesNotes()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $coursIds      = $enseignant->cours()->pluck('id');
        $evaluationIds = Evaluation::whereIn('cours_id', $coursIds)->pluck('id');

        $notes = Note::whereIn('evaluation_id', $evaluationIds)
            ->with(['etudiant.user', 'evaluation.cours'])
            ->latest()
            ->get();

        $evaluations = Evaluation::whereIn('cours_id', $coursIds)->with('cours')->get();

        $classeIds = $enseignant->cours()->with('classes')->get()
            ->flatMap->classes->unique('id')->pluck('id');
        $etudiants = Etudiant::whereIn('classe_id', $classeIds)->with('user')->get();

        return view('pages.enseignant.Note.liste', compact('enseignant', 'notes', 'evaluations', 'etudiants'));
    }

    public function mesPresences()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $coursIds  = $enseignant->cours()->pluck('id');
        $presences = Presence::whereIn('cours_id', $coursIds)
            ->with(['etudiant.user', 'cours'])
            ->orderBy('date', 'desc')
            ->get();

        $cours = $enseignant->cours()->get();

        $classeIds = $enseignant->cours()->with('classes')->get()
            ->flatMap->classes->unique('id')->pluck('id');
        $etudiants = Etudiant::whereIn('classe_id', $classeIds)->with('user')->get();

        return view('pages.enseignant.Presence.liste', compact('enseignant', 'presences', 'cours', 'etudiants'));
    }

    public function mesClasses()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $classes = $enseignant->cours()
            ->with('classes.etudiants.user')
            ->get()
            ->flatMap->classes
            ->unique('id');

        // Étudiants sans classe ou dans une autre classe (pour pouvoir les ajouter)
        $tousEtudiants = Etudiant::with('user')->orderBy('id')->get();

        return view('pages.enseignant.Classe.liste', compact('enseignant', 'classes', 'tousEtudiants'));
    }

    /**
     * Affecte un étudiant à une classe de l'enseignant.
     */
    public function ajouterEtudiant(Request $request, Classe $classe)
    {
        $enseignant = Auth::user()->enseignant;
        $classeIds  = $enseignant->cours()->with('classes')->get()
            ->flatMap->classes->unique('id')->pluck('id');

        if (!$classeIds->contains($classe->id)) abort(403);

        $request->validate([
            'etudiant_matricule' => ['required', 'string', 'exists:etudiants,matricule'],
        ]);

        Etudiant::where('matricule', $request->etudiant_matricule)
            ->update(['classe_id' => $classe->id]);

        return redirect()->back()->with('success', 'Étudiant ajouté à la classe.');
    }

    /**
     * Retire un étudiant d'une classe de l'enseignant (classe_id → null).
     */
    public function retirerEtudiant(Classe $classe, Etudiant $etudiant)
    {
        $enseignant = Auth::user()->enseignant;
        $classeIds  = $enseignant->cours()->with('classes')->get()
            ->flatMap->classes->unique('id')->pluck('id');

        if (!$classeIds->contains($classe->id)) abort(403);

        $etudiant->update(['classe_id' => null]);

        return redirect()->back()->with('success', 'Étudiant retiré de la classe.');
    }

    public function mesEtudiants()
    {
        $enseignant = Auth::user()->enseignant;
        if (!$enseignant) abort(403);

        $classeIds = $enseignant->cours()->with('classes')->get()
            ->flatMap->classes->unique('id')->pluck('id');
        $etudiants = Etudiant::whereIn('classe_id', $classeIds)
            ->with(['user', 'classe'])
            ->get();

        return view('pages.enseignant.Etudiant.liste', compact('enseignant', 'etudiants'));
    }

    // ─── Admin : gestion des enseignants ──────────────────────────────────────

    public function index()
    {
        $enseignants = Enseignant::with(['user', 'cours'])->latest()->paginate(15);
        return view('pages.admin.Enseignant.liste', compact('enseignants'));
    }

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

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->user->delete();
        return redirect()->back()->with('success', 'Enseignant supprimé avec succès.');
    }
}
