<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'                  => User::factory()->administrateur(),
            'departement'              => fake()->randomElement(['Direction', 'Scolarité', 'Finances', 'Informatique']),
            'telephone'                => fake()->numerify('06########'),
            'matricule_administrateur' => 'ADM-' . fake()->unique()->numerify('###'),
        ];
    }
}
