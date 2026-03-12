<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur connecté possède l'un des rôles requis.
     * Usage dans les routes : ->middleware('role:recteur') ou ->middleware('role:enseignant,vacataire')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (! in_array($userRole, $roles)) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    }
}
