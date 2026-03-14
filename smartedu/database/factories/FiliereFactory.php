<?php

namespace Database\Factories;

use App\Models\Departement;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiliereFactory extends Factory
{
    public function definition(): array
    {
        $noms = [
            'Licence Informatique',
            'Master Informatique',
            'Licence Mathématiques',
            'Licence Physique',
            'Licence Économie',
            'Licence Gestion',
            'Licence Droit',
            'Master Finance',
            'Licence Biologie',
        ];

        return [
            'tenant_id'      => Tenant::factory(),
            'departement_id' => Departement::factory(),
            'nom'            => fake()->unique()->randomElement($noms),
            'code'           => strtoupper(fake()->unique()->lexify('FIL??')),
            'duree_annees'   => fake()->randomElement([3, 5]),
        ];
    }
}
