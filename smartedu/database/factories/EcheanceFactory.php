<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Tarif;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EcheanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'etudiant_id' => Etudiant::factory(),
            'tarif_id'    => Tarif::factory(),
            'numero_mois' => fake()->numberBetween(1, 9),
            'montant'     => fake()->randomElement([33333, 50000, 66667, 83333]),
            'date_limite' => fake()->dateTimeBetween('now', '+9 months')->format('Y-m-d'),
            'statut'      => 'en_attente',
        ];
    }

    public function paye(): static
    {
        return $this->state(fn () => ['statut' => 'paye']);
    }

    public function retard(): static
    {
        return $this->state(fn () => [
            'statut'      => 'retard',
            'date_limite' => fake()->dateTimeBetween('-3 months', '-1 day')->format('Y-m-d'),
        ]);
    }
}
