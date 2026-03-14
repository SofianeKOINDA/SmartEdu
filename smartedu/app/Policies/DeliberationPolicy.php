<?php

namespace App\Policies;

use App\Models\Deliberation;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class DeliberationPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Deliberation $deliberation): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->etudiant && $user->etudiant->id === $deliberation->etudiant_id;
        }

        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $deliberation);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Deliberation $deliberation): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $deliberation);
    }

    public function delete(User $user, Deliberation $deliberation): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $deliberation);
    }
}
