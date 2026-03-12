<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnneeScolaireFactory extends Factory
{
    public function definition(): array
    {
        $annee = fake()->numberBetween(2022, 2026);

        return [
            'tenant_id'  => Tenant::factory(),
            'libelle'    => $annee . '-' . ($annee + 1),
            'date_debut' => $annee . '-09-01',
            'date_fin'   => ($annee + 1) . '-07-31',
            'courante'   => false,
        ];
    }

    public function courante(): static
    {
        return $this->state(fn () => [
            'libelle'    => '2025-2026',
            'date_debut' => '2025-09-01',
            'date_fin'   => '2026-07-31',
            'courante'   => true,
        ]);
    }
}
