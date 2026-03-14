<?php

namespace App\Policies;

use App\Models\AnneeScolaire;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class AnneeScolairePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user);
    }

    public function view(User $user, AnneeScolaire $anneeScolaire): bool
    {
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $anneeScolaire);
    }

    public function create(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, AnneeScolaire $anneeScolaire): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $anneeScolaire);
    }

    public function delete(User $user, AnneeScolaire $anneeScolaire): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $anneeScolaire);
    }
}
