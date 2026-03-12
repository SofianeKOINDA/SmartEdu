<?php

namespace App\Policies;

use App\Models\Etudiant;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class EtudiantPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user);
    }

    public function view(User $user, Etudiant $etudiant): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->id === $etudiant->user_id;
        }

        return ($this->isManagerOrAbove($user) || $this->isEnseignant($user))
            && $this->sameTenant($user, $etudiant);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Etudiant $etudiant): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $etudiant);
    }

    public function delete(User $user, Etudiant $etudiant): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $etudiant);
    }
}
