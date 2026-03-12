<?php

namespace App\Policies;

use App\Models\Filiere;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class FilierePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Filiere $filiere): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $filiere);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Filiere $filiere): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $filiere);
    }

    public function delete(User $user, Filiere $filiere): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $filiere);
    }
}
