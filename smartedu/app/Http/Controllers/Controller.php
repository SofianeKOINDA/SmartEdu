<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Get the authenticated etudiant
     */
    protected function getEtudiant()
    {
        return auth()->user()?->etudiant;
    }

    /**
     * Get the authenticated enseignant
     */
    protected function getEnseignant()
    {
        return auth()->user()?->enseignant;
    }

    /**
     * Get the authenticated user's tenant ID
     */
    protected function getTenantId()
    {
        return auth()->user()?->tenant_id;
    }
}
