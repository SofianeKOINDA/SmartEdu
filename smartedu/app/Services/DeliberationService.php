<?php

namespace App\Services;

use App\Models\Deliberation;
use App\Models\Etudiant;
use App\Models\Semestre;
use Illuminate\Support\Facades\Auth;

class DeliberationService
{
    /**
     * Calcule la moyenne pondérée d'un étudiant pour un semestre.
     */
    public function calculerMoyenne(Etudiant $etudiant, Semestre $semestre): float
    {
        $ues = $semestre->ues()
            ->withoutGlobalScope('tenant')
            ->with([
                'cours' => function ($q) use ($etudiant) {
                    $q->withoutGlobalScope('tenant')
                      ->with([
                          'evaluations' => function ($q2) use ($etudiant) {
                              $q2->withoutGlobalScope('tenant')
                                 ->with([
                                     'notes' => function ($q3) use ($etudiant) {
                                         $q3->withoutGlobalScope('tenant')
                                            ->where('etudiant_id', $etudiant->id);
                                     },
                                 ]);
                          },
                      ]);
                },
            ])
            ->get();

        $totalPoints = 0;
        $totalCoefficients = 0;

        foreach ($ues as $ue) {
            foreach ($ue->cours as $cours) {
                $moyenneCours = $this->calculerMoyenneCours($cours);
                if ($moyenneCours !== null) {
                    $totalPoints += $moyenneCours * $cours->coefficient;
                    $totalCoefficients += $cours->coefficient;
                }
            }
        }

        if ($totalCoefficients === 0) {
            return 0.0;
        }

        return round($totalPoints / $totalCoefficients, 2);
    }

    /**
     * Calcule la moyenne d'un étudiant et enregistre la délibération.
     */
    public function deliberer(Etudiant $etudiant, Semestre $semestre): Deliberation
    {
        $moyenne = $this->calculerMoyenne($etudiant, $semestre);

        $decision = match (true) {
            $moyenne >= 10 => 'admis',
            $moyenne >= 8  => 'rattrapage',
            default        => 'redoublant',
        };

        return Deliberation::updateOrCreate(
            [
                'etudiant_id' => $etudiant->id,
                'semestre_id' => $semestre->id,
            ],
            [
                'tenant_id'    => $etudiant->tenant_id,
                'moyenne'      => $moyenne,
                'decision'     => $decision,
                'delibere_par' => Auth::id(),
                'delibere_le'  => now(),
            ]
        );
    }

    private function calculerMoyenneCours($cours): ?float
    {
        $evaluations = $cours->evaluations;

        if ($evaluations->isEmpty()) {
            return null;
        }

        $totalPoints = 0;
        $totalCoefficients = 0;

        foreach ($evaluations as $evaluation) {
            $note = $evaluation->notes->first();
            if ($note !== null) {
                $noteNormalisee = ($note->valeur / $evaluation->note_max) * 20;
                $totalPoints += $noteNormalisee * $evaluation->coefficient;
                $totalCoefficients += $evaluation->coefficient;
            }
        }

        if ($totalCoefficients === 0) {
            return null;
        }

        return round($totalPoints / $totalCoefficients, 2);
    }
}
