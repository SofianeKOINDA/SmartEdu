<?php

namespace Database\Factories;

use App\Models\Semestre;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class UEFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'semestre_id' => Semestre::factory(),
            'nom'         => 'UE ' . fake()->unique()->word(),
            'code'        => strtoupper(fake()->unique()->lexify('UE???')),
            'coefficient' => fake()->randomElement([1, 1.5, 2, 3]),
            'credit'      => fake()->numberBetween(2, 6),
        ];
    }
}
