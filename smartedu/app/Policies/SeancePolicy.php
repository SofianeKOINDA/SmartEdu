<?php

namespace App\Policies;

use App\Models\Seance;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class SeancePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return true; // Tous les rôles peuvent voir les séances (emploi du temps)
    }

    public function view(User $user, Seance $seance): bool
    {
        return $this->sameTenant($user, $seance);
    }

    public function create(User $user): bool
    {
        return $this->isChefDepartement($user) || $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Seance $seance): bool
    {
        return ($this->isChefDepartement($user) || $this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $seance);
    }

    public function delete(User $user, Seance $seance): bool
    {
        return ($this->isChefDepartement($user) || $this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $seance);
    }
}
