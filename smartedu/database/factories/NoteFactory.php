<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'     => Tenant::factory(),
            'evaluation_id' => Evaluation::factory(),
            'etudiant_id'   => Etudiant::factory(),
            'saisi_par'     => User::factory()->enseignant(),
            'valeur'        => fake()->randomFloat(2, 0, 20),
            'commentaire'   => fake()->optional(0.3)->sentence(),
        ];
    }

    public function admis(): static
    {
        return $this->state(fn () => ['valeur' => fake()->randomFloat(2, 10, 20)]);
    }

    public function recale(): static
    {
        return $this->state(fn () => ['valeur' => fake()->randomFloat(2, 0, 9.99)]);
    }
}
