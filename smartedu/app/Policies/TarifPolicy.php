<?php

namespace App\Policies;

use App\Models\Tarif;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class TarifPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function view(User $user, Tarif $tarif): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $tarif);
    }

    public function create(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Tarif $tarif): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $tarif);
    }

    public function delete(User $user, Tarif $tarif): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $tarif);
    }
}
