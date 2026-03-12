<?php

namespace App\Policies;

use App\Models\UE;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class UEPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user);
    }

    public function view(User $user, UE $ue): bool
    {
        return ($this->isManagerOrAbove($user) || $this->isEnseignant($user))
            && $this->sameTenant($user, $ue);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, UE $ue): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $ue);
    }

    public function delete(User $user, UE $ue): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $ue);
    }
}
