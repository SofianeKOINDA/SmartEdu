<?php

namespace App\Exports;

use App\Models\Echeance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EcheancesExport implements FromCollection, WithHeadings
{
    public function __construct(private int $tenantId) {}

    public function headings(): array
    {
        return [
            'Echeance_ID',
            'Etudiant',
            'Email',
            'AnneeScolaire',
            'Mois',
            'Montant',
            'DateLimite',
            'Statut',
        ];
    }

    public function collection(): Collection
    {
        return Echeance::with(['etudiant.user', 'tarif.anneeScolaire'])
            ->withoutGlobalScope('tenant')
            ->where('tenant_id', $this->tenantId)
            ->orderBy('etudiant_id')
            ->orderBy('numero_mois')
            ->get()
            ->map(function (Echeance $e) {
                $u = $e->etudiant?->user;
                return [
                    $e->id,
                    trim(($u->prenom ?? '') . ' ' . ($u->nom ?? '')),
                    $u->email ?? null,
                    $e->tarif?->anneeScolaire?->libelle ?? null,
                    $e->numero_mois,
                    (string) $e->montant,
                    $e->date_limite?->format('Y-m-d'),
                    $e->statut,
                ];
            });
    }
}

