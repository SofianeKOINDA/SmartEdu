<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnseignantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'              => User::factory()->enseignant(),
            'specialite'           => fake()->randomElement(['Mathématiques', 'Physique', 'Informatique', 'Français', 'Histoire', 'Anglais']),
            'telephone'            => fake()->numerify('06########'),
            'matricule_enseignant' => 'ENS-' . fake()->unique()->numerify('###'),
        ];
    }
}
