<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'        => User::factory()->etudiant(),
            'matricule'      => 'ETU-' . fake()->unique()->numerify('####'),
            'date_naissance' => fake()->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
            'classe_id'      => null,
        ];
    }
}
