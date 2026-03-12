<?php

namespace App\Policies;

use App\Models\Semestre;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class SemestrePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, Semestre $semestre): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $semestre);
    }

    public function create(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Semestre $semestre): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $semestre);
    }

    public function delete(User $user, Semestre $semestre): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $semestre);
    }
}
