<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Paiement;
use App\Http\Requests\StoreAdministrateurRequest;
use App\Http\Requests\UpdateAdministrateurRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    /**
     * Dashboard principal de l'administrateur.
     */
    public function dashboard()
    {
        $stats = [
            'nb_etudiants'    => Etudiant::count(),
            'nb_enseignants'  => Enseignant::count(),
            'nb_cours'        => Cours::count(),
            'nb_classes'      => Classe::count(),
            'total_paiements' => Paiement::where('statut', 'valide')->sum('montant'),
        ];

        $etudiants       = Etudiant::with(['user', 'classe'])->latest()->paginate(15, ['*'], 'etudiants_page');
        $enseignants     = Enseignant::with('user')->latest()->get();
        $administrateurs = Administrateur::with('user')->latest()->get();
        $classes         = Classe::withCount('etudiants')->with('cours')->get();
        $cours           = Cours::with('enseignant.user')->withCount('evaluations')->latest()->get();
        $paiements       = Paiement::with('etudiant.user')->latest('date')->paginate(10, ['*'], 'paiements_page');

        return view('dashbord', compact(
            'stats', 'etudiants', 'enseignants', 'administrateurs',
            'classes', 'cours', 'paiements'
        ));
    }

    /**
     * Créer un administrateur (User + Administrateur) via modal.
     */
    public function store(StoreAdministrateurRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'nom'    => $request->nom,
                'prenom' => $request->prenom,
                'email'  => $request->email,
                'password' => Hash::make($request->password),
                'role'   => 'admin',
            ]);

            Administrateur::create([
                'user_id'                  => $user->id,
                'departement'              => $request->departement,
                'telephone'                => $request->telephone,
                'matricule_administrateur' => $request->matricule_administrateur,
            ]);
        });

        return redirect()->back()->with('success', 'Administrateur créé avec succès.');
    }

    /**
     * Mettre à jour un administrateur via modal.
     */
    public function update(UpdateAdministrateurRequest $request, Administrateur $administrateur)
    {
        DB::transaction(function () use ($request, $administrateur) {
            $userFields = array_filter([
                'nom'    => $request->nom,
                'prenom' => $request->prenom,
                'email'  => $request->email,
                'password' => $request->password ? Hash::make($request->password) : null,
            ]);
            if (isset($userFields['password']) && !$userFields['password']) {
                unset($userFields['password']);
            }
            $administrateur->user->update($userFields);

            $administrateur->update($request->only([
                'departement', 'telephone', 'matricule_administrateur',
            ]));
        });

        return redirect()->back()->with('success', 'Administrateur mis à jour avec succès.');
    }

    /**
     * Supprimer un administrateur (et son user) via modal.
     */
    public function destroy(Administrateur $administrateur)
    {
        $administrateur->user->delete(); // cascade supprime l'administrateur
        return redirect()->back()->with('success', 'Administrateur supprimé avec succès.');
    }
}
