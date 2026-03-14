<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresenceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'cours_id'    => Cours::factory(),
            'etudiant_id' => Etudiant::factory(),
            'saisi_par'   => User::factory()->enseignant(),
            'date_seance' => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'statut'      => fake()->randomElement(['present', 'present', 'present', 'absent', 'retard']),
            'observation' => fake()->optional(0.2)->sentence(),
        ];
    }

    public function present(): static
    {
        return $this->state(fn () => ['statut' => 'present']);
    }

    public function absent(): static
    {
        return $this->state(fn () => ['statut' => 'absent']);
    }
}
