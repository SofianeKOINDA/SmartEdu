<?php

namespace App\Services;

use App\Models\Etudiant;
use App\Models\Semestre;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class BulletinService
{
    /**
     * Génère le bulletin (PDF relevé de notes) pour un étudiant et un semestre donnés.
     */
    public function generer(Etudiant $etudiant, Semestre $semestre): Response
    {
        $etudiant->load([
            'user',
            'promotion.filiere.departement.faculte',
        ]);

        // Récupère les UEs du semestre avec les cours et les notes de l'étudiant
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

        $deliberation = $etudiant->deliberations()
            ->withoutGlobalScope('tenant')
            ->where('semestre_id', $semestre->id)
            ->first();

        $pdf = Pdf::loadView('bulletins.releve', compact('etudiant', 'semestre', 'ues', 'deliberation'));

        return $pdf->download('bulletin_' . $etudiant->numero_etudiant . '_S' . $semestre->numero . '.pdf');
    }
}
