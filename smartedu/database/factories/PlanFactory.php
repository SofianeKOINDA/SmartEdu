<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom'              => fake()->randomElement(['Starter', 'Pro', 'Enterprise']),
            'description'      => fake()->sentence(),
            'prix_mensuel'     => fake()->randomElement([0, 29900, 59900, 99900]),
            'max_etudiants'    => fake()->randomElement([100, 500, 2000, null]),
            'max_enseignants'  => fake()->randomElement([20, 100, 500, null]),
            'actif'            => true,
        ];
    }

    public function inactif(): static
    {
        return $this->state(fn () => ['actif' => false]);
    }
}
