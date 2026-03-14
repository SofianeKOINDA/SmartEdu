<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('welcome');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => "L'adresse email est requise.",
            'email.email'       => "L'adresse email n'est pas valide.",
            'password.required' => 'Le mot de passe est requis.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email ou mot de passe incorrect.']);
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'super_admin'      => redirect()->route('super_admin.tenants.index'),
            'recteur'          => redirect()->route('recteur.dashboard'),
            'doyen'            => redirect()->route('doyen.facultes.index'),
            'chef_departement' => redirect()->route('chef_departement.seances.index'),
            'enseignant',
            'vacataire'        => redirect()->route('enseignant.cours.index'),
            default            => redirect()->route('etudiant.dashboard'),
        };
    }
}
