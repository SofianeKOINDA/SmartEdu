<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Semestre;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliberationFactory extends Factory
{
    public function definition(): array
    {
        $moyenne = fake()->randomFloat(2, 0, 20);

        return [
            'tenant_id'    => Tenant::factory(),
            'etudiant_id'  => Etudiant::factory(),
            'semestre_id'  => Semestre::factory(),
            'moyenne'      => $moyenne,
            'decision'     => match (true) {
                $moyenne >= 10 => 'admis',
                $moyenne >= 8  => 'rattrapage',
                default        => 'redoublant',
            },
            'observation'  => fake()->optional(0.4)->sentence(),
            'delibere_par' => User::factory()->doyen(),
            'delibere_le'  => now(),
        ];
    }

    public function admis(): static
    {
        return $this->state(fn () => ['moyenne' => fake()->randomFloat(2, 10, 20), 'decision' => 'admis']);
    }

    public function enAttente(): static
    {
        return $this->state(fn () => ['moyenne' => null, 'decision' => 'en_attente', 'delibere_par' => null, 'delibere_le' => null]);
    }
}
