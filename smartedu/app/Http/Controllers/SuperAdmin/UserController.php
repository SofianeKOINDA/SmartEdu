<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('tenant')
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('super_admin.users.index', compact('users'));
    }

    public function desactiver(User $user)
    {
        // Désactivation simple via suppression du remember_token (placeholder)
        $user->update(['remember_token' => null]);

        return redirect()->route('super_admin.users.index')->with('success', 'Compte désactivé (placeholder).');
    }

    public function resetPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('super_admin.users.index')->with('success', 'Mot de passe réinitialisé.');
    }
}

