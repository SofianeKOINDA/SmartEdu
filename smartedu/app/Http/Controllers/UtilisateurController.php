<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $users = User::with(['etudiant', 'enseignant', 'administrateur'])->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        $user->load(['etudiant', 'enseignant', 'administrateur']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
