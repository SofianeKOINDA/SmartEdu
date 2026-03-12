<?php

namespace App\Policies;

use App\Models\Departement;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class DepartementPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Departement $departement): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $departement);
    }

    public function create(User $user): bool
    {
        return $this->isRecteur($user) || $this->isDoyen($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Departement $departement): bool
    {
        return ($this->isRecteur($user) || $this->isDoyen($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $departement);
    }

    public function delete(User $user, Departement $departement): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $departement);
    }
}
