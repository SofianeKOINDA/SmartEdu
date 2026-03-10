<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur connecté possède le rôle requis.
     * Usage dans les routes : ->middleware('role:admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            // Redirige vers le bon dashboard au lieu d'un 403 brutal
            return match($userRole) {
                'admin'      => redirect()->route('admin.dashboard'),
                'enseignant' => redirect()->route('enseignant.dashboard'),
                default      => redirect()->route('etudiant.dashboard'),
            };
        }

        return $next($request);
    }
}
