<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemestreFactory extends Factory
{
    public function definition(): array
    {
        $numero = fake()->numberBetween(1, 2);

        return [
            'tenant_id'          => Tenant::factory(),
            'annee_scolaire_id'  => AnneeScolaire::factory(),
            'nom'                => 'Semestre ' . $numero,
            'numero'             => $numero,
            'date_debut'         => null,
            'date_fin'           => null,
            'actif'              => false,
        ];
    }

    public function actif(): static
    {
        return $this->state(fn () => [
            'actif'      => true,
            'date_debut' => now()->startOfMonth(),
            'date_fin'   => now()->addMonths(4),
        ]);
    }
}
