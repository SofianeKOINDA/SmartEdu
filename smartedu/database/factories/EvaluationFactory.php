<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'        => Tenant::factory(),
            'cours_id'         => Cours::factory(),
            'intitule'         => fake()->randomElement(['Devoir 1', 'Devoir 2', 'Examen Mi-Semestre', 'Examen Final', 'TP Noté', 'Projet']),
            'type'             => fake()->randomElement(['devoir', 'examen', 'tp', 'projet']),
            'coefficient'      => fake()->randomElement([1, 2, 3]),
            'note_max'         => 20,
            'date_evaluation'  => fake()->dateTimeBetween('-3 months', '+1 month')->format('Y-m-d'),
        ];
    }

    public function examen(): static
    {
        return $this->state(fn () => ['type' => 'examen', 'coefficient' => 3, 'intitule' => 'Examen Final']);
    }

    public function devoir(): static
    {
        return $this->state(fn () => ['type' => 'devoir', 'coefficient' => 1]);
    }
}
