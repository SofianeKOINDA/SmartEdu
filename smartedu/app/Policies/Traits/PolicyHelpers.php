<?php

namespace App\Policies\Traits;

use App\Models\User;

trait PolicyHelpers
{
    protected function isSuperAdmin(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    protected function isRecteur(User $user): bool
    {
        return $user->role === 'recteur';
    }

    protected function isDoyen(User $user): bool
    {
        return $user->role === 'doyen';
    }

    protected function isChefDepartement(User $user): bool
    {
        return $user->role === 'chef_departement';
    }

    protected function isEnseignant(User $user): bool
    {
        return in_array($user->role, ['enseignant', 'vacataire']);
    }

    protected function isEtudiant(User $user): bool
    {
        return $user->role === 'etudiant';
    }

    protected function sameTenant(User $user, $model): bool
    {
        return $user->tenant_id === $model->tenant_id;
    }

    protected function isManagerOrAbove(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    protected function canManageTenant(User $user, $model): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        return $this->sameTenant($user, $model);
    }
}
