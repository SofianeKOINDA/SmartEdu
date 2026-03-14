<?php

namespace App\Policies;

use App\Models\Faculte;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class FacultePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Faculte $faculte): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $faculte);
    }

    public function create(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Faculte $faculte): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $faculte);
    }

    public function delete(User $user, Faculte $faculte): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $faculte);
    }
}
