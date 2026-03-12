<?php

namespace App\Services;

use App\Models\Seance;
use Illuminate\Validation\ValidationException;

class EmploiDuTempsService
{
    /**
     * Vérifie les conflits de salle, enseignant et promotion avant création.
     *
     * @throws ValidationException si un conflit est détecté
     */
    public function verifierConflits(array $data): void
    {
        $query = Seance::withoutGlobalScope('tenant')
            ->where('tenant_id', $data['tenant_id'])
            ->where('jour', $data['jour'])
            ->where('heure_debut', $data['heure_debut']);

        if (isset($data['id'])) {
            $query->where('id', '!=', $data['id']);
        }

        // Conflit de salle
        if (!empty($data['salle'])) {
            $conflitSalle = (clone $query)
                ->where('salle', $data['salle'])
                ->exists();

            if ($conflitSalle) {
                throw ValidationException::withMessages([
                    'salle' => ["La salle '{$data['salle']}' est déjà occupée à ce créneau."],
                ]);
            }
        }

        // Conflit d'enseignant (via le cours)
        $conflitEnseignant = (clone $query)
            ->whereHas('cours', function ($q) use ($data) {
                $q->where('enseignant_id', $data['enseignant_id'] ?? null);
            })
            ->exists();

        if ($conflitEnseignant) {
            throw ValidationException::withMessages([
                'cours_id' => ["L'enseignant a déjà une séance à ce créneau."],
            ]);
        }

        // Conflit de promotion
        $conflitPromotion = (clone $query)
            ->where('promotion_id', $data['promotion_id'])
            ->exists();

        if ($conflitPromotion) {
            throw ValidationException::withMessages([
                'promotion_id' => ["Cette promotion a déjà une séance à ce créneau."],
            ]);
        }
    }

    /**
     * Crée une séance après vérification des conflits.
     */
    public function creerSeance(array $data): Seance
    {
        $this->verifierConflits($data);

        return Seance::create($data);
    }
}
