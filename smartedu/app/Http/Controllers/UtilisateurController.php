<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Liste de tous les utilisateurs (admin seulement).
     */
    public function index()
    {
        $users = User::with(['etudiant', 'enseignant', 'administrateur'])
            ->orderBy('role')
            ->paginate(20);
        return view('pages.admin.User.liste', compact('users'));
    }

    /**
     * Créer un utilisateur simple via modal (sans profil associé).
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);
        return redirect()->back()->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Mettre à jour un utilisateur via modal.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return redirect()->back()->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur via modal.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
