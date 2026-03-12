<?php

namespace Database\Factories;

use App\Models\Faculte;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartementFactory extends Factory
{
    public function definition(): array
    {
        $noms = [
            'Informatique',
            'Mathématiques',
            'Physique',
            'Chimie',
            'Biologie',
            'Génie Civil',
            'Génie Électrique',
            'Économie',
            'Gestion',
            'Droit Privé',
            'Droit Public',
            'Philosophie',
            'Histoire',
            'Géographie',
        ];

        return [
            'tenant_id'  => Tenant::factory(),
            'faculte_id' => Faculte::factory(),
            'nom'        => fake()->unique()->randomElement($noms),
            'code'       => strtoupper(fake()->unique()->lexify('D???')),
        ];
    }
}
