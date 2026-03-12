<?php

namespace App\Policies;

use App\Models\Cours;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class CoursPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user);
    }

    public function view(User $user, Cours $cours): bool
    {
        if ($this->isEtudiant($user)) {
            // Étudiant voit uniquement ses cours via sa promotion
            return $user->etudiant
                && $cours->whereHas('inscriptionsPedagogiques', function ($q) use ($user) {
                    $q->where('etudiant_id', $user->etudiant->id);
                })->exists()
                && $this->sameTenant($user, $cours);
        }

        return ($this->isManagerOrAbove($user) || $this->isEnseignant($user))
            && $this->sameTenant($user, $cours);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement']);
    }

    public function update(User $user, Cours $cours): bool
    {
        return in_array($user->role, ['super_admin', 'recteur', 'doyen', 'chef_departement'])
            && $this->sameTenant($user, $cours);
    }

    public function delete(User $user, Cours $cours): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $cours);
    }
}
