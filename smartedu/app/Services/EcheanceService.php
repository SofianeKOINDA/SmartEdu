<?php

namespace App\Services;

use App\Models\Echeance;
use App\Models\Etudiant;
use App\Models\Tarif;
use Carbon\Carbon;

class EcheanceService
{
    /**
     * Génère les échéances mensuelles pour TOUS les étudiants actifs du tenant.
     * Déclenché automatiquement à la création d'un Tarif.
     */
    public function genererPourTousLesEtudiants(Tarif $tarif): void
    {
        $etudiants = Etudiant::withoutGlobalScope('tenant')
            ->where('tenant_id', $tarif->tenant_id)
            ->where('actif', true)
            ->get();

        foreach ($etudiants as $etudiant) {
            $this->creerEcheances($tarif, $etudiant);
        }
    }

    /**
     * Génère les échéances pour un seul étudiant (inscription après création du tarif).
     * Déclenché automatiquement à la création d'un Etudiant.
     */
    public function genererPourEtudiant(Etudiant $etudiant): void
    {
        $tarif = Tarif::withoutGlobalScope('tenant')
            ->where('tenant_id', $etudiant->tenant_id)
            ->whereHas('anneeScolaire', function ($q) {
                $q->where('courante', true);
            })
            ->first();

        if ($tarif === null) {
            return;
        }

        $this->creerEcheances($tarif, $etudiant);
    }

    private function creerEcheances(Tarif $tarif, Etudiant $etudiant): void
    {
        $montantMensuel = round($tarif->montant_total / $tarif->nombre_echeances, 2);
        $anneeScolaire = $tarif->anneeScolaire;

        $dateDebut = Carbon::parse($anneeScolaire->date_debut)->startOfMonth();

        for ($i = 1; $i <= $tarif->nombre_echeances; $i++) {
            $dateLimite = $dateDebut->copy()->addMonths($i - 1)->day($tarif->jour_limite);

            Echeance::firstOrCreate(
                [
                    'etudiant_id' => $etudiant->id,
                    'tarif_id'    => $tarif->id,
                    'numero_mois' => $i,
                ],
                [
                    'tenant_id'  => $tarif->tenant_id,
                    'montant'    => $montantMensuel,
                    'date_limite' => $dateLimite,
                    'statut'     => 'en_attente',
                ]
            );
        }
    }
}
