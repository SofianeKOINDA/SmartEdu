<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return match(Auth::user()->role) {
                    'super_admin'      => redirect()->route('super_admin.dashboard'),
                    'recteur'          => redirect()->route('recteur.dashboard'),
                    'doyen'            => redirect()->route('doyen.dashboard'),
                    'chef_departement' => redirect()->route('chef_departement.dashboard'),
                    'enseignant',
                    'vacataire'        => redirect()->route('enseignant.dashboard'),
                    default            => redirect()->route('etudiant.dashboard'),
                };
            }
        }

        return $next($request);
    }
}
