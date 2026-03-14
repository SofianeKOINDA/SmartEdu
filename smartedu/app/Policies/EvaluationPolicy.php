<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use App\Policies\Traits\PolicyHelpers;

class EvaluationPolicy
{
    use PolicyHelpers;

    public function viewAny(User $user): bool
    {
        return $this->isManagerOrAbove($user) || $this->isEnseignant($user) || $this->isEtudiant($user);
    }

    public function view(User $user, Evaluation $evaluation): bool
    {
        return $this->sameTenant($user, $evaluation);
    }

    public function create(User $user): bool
    {
        return $this->isEnseignant($user) || $this->isManagerOrAbove($user);
    }

    public function update(User $user, Evaluation $evaluation): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $evaluation);
    }

    public function delete(User $user, Evaluation $evaluation): bool
    {
        return ($this->isEnseignant($user) || $this->isManagerOrAbove($user))
            && $this->sameTenant($user, $evaluation);
    }
}
