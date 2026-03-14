<?php

namespace App\Policies;

use App\Models\Demande;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class DemandePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Demande $demande): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->etudiant && $user->etudiant->id === $demande->etudiant_id;
        }

        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $demande);
    }

    public function create(User $user): bool
    {
        return $this->isEtudiant($user);
    }

    public function update(User $user, Demande $demande): bool
    {
        // Seuls les managers peuvent mettre à jour (changer le statut, répondre)
        return $this->isManagerOrAbove($user) && $this->sameTenant($user, $demande);
    }

    public function delete(User $user, Demande $demande): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $demande);
    }

    /**
     * Un étudiant peut annuler SA demande si elle est en statut 'en_attente'.
     */
    public function annuler(User $user, Demande $demande): bool
    {
        if (! $this->isEtudiant($user)) {
            return false;
        }

        return $user->etudiant
            && $user->etudiant->id === $demande->etudiant_id
            && $demande->statut === 'en_attente';
    }
}
