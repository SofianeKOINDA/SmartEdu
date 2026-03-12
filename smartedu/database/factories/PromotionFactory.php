<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Filiere;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    public function definition(): array
    {
        $niveau = fake()->numberBetween(1, 5);

        return [
            'tenant_id'          => Tenant::factory(),
            'filiere_id'         => Filiere::factory(),
            'annee_scolaire_id'  => AnneeScolaire::factory(),
            'nom'                => 'L' . $niveau,
            'niveau'             => $niveau,
        ];
    }
}
