<?php

namespace App\Policies;

use App\Models\Presence;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class PresencePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Presence $presence): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->etudiant && $user->etudiant->id === $presence->etudiant_id;
        }

        return ($this->isManagerOrAbove($user) || $this->isEnseignant($user))
            && $this->sameTenant($user, $presence);
    }

    public function create(User $user): bool
    {
        return $this->isEnseignant($user) || $this->isManagerOrAbove($user);
    }

    public function update(User $user, Presence $presence): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $presence);
    }

    public function delete(User $user, Presence $presence): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $presence);
    }
}
