<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenantFactory extends Factory
{
    public function definition(): array
    {
        $nom = fake()->company() . ' Université';

        return [
            'plan_id'   => Plan::factory(),
            'nom'       => $nom,
            'slug'      => Str::slug($nom) . '-' . fake()->unique()->numerify('###'),
            'email'     => fake()->companyEmail(),
            'telephone' => fake()->phoneNumber(),
            'adresse'   => fake()->address(),
            'logo'      => null,
            'actif'     => true,
        ];
    }

    public function inactif(): static
    {
        return $this->state(fn () => ['actif' => false]);
    }
}
