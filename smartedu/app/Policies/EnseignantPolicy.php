<?php

namespace App\Policies;

use App\Models\Enseignant;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class EnseignantPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Enseignant $enseignant): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $enseignant);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Enseignant $enseignant): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $enseignant);
    }

    public function delete(User $user, Enseignant $enseignant): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $enseignant);
    }
}
