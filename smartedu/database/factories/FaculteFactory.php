<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaculteFactory extends Factory
{
    public function definition(): array
    {
        $noms = [
            'Faculté des Sciences et Technologies',
            'Faculté des Lettres et Sciences Humaines',
            'Faculté de Droit et Sciences Politiques',
            'Faculté des Sciences Économiques et de Gestion',
            'Faculté de Médecine',
            'Faculté des Sciences de l\'Éducation',
        ];

        return [
            'tenant_id'   => Tenant::factory(),
            'nom'         => fake()->unique()->randomElement($noms),
            'code'        => strtoupper(fake()->unique()->lexify('F??')),
            'description' => fake()->sentence(),
        ];
    }
}
