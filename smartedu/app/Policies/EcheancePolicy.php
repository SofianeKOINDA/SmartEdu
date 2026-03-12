<?php

namespace App\Policies;

use App\Models\Echeance;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class EcheancePolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isRecteur($user) || $this->isSuperAdmin($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Echeance $echeance): bool
    {
        if ($this->isEtudiant($user)) {
            return $user->etudiant && $user->etudiant->id === $echeance->etudiant_id;
        }

        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $echeance);
    }

    public function create(User $user): bool
    {
        // Les échéances sont créées automatiquement via EcheanceService
        return $this->isRecteur($user) || $this->isSuperAdmin($user);
    }

    public function update(User $user, Echeance $echeance): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $echeance);
    }

    public function delete(User $user, Echeance $echeance): bool
    {
        return ($this->isRecteur($user) || $this->isSuperAdmin($user))
            && $this->sameTenant($user, $echeance);
    }

    /**
     * L'étudiant peut déclencher le paiement uniquement sur SES PROPRES échéances non payées.
     */
    public function payer(User $user, Echeance $echeance): bool
    {
        if (! $this->isEtudiant($user)) {
            return false;
        }

        if (! $user->etudiant) {
            return false;
        }

        return $user->etudiant->id === $echeance->etudiant_id
            && ! $echeance->estPayee()
            && $this->sameTenant($user, $echeance);
    }
}
