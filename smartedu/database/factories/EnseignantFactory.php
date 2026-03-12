<?php

namespace Database\Factories;

use App\Models\Departement;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnseignantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'      => Tenant::factory(),
            'user_id'        => User::factory()->enseignant(),
            'departement_id' => null,
            'grade'          => fake()->randomElement(['Professeur', 'Maître de Conférences', 'Assistant', 'Vacataire', 'Docteur']),
            'specialite'     => fake()->randomElement(['Algorithmique', 'Bases de données', 'Réseaux', 'IA', 'Mathématiques', 'Physique']),
            'bureau'         => fake()->optional(0.7)->regexify('[A-C][0-9]{3}'),
            'matricule'      => strtoupper(fake()->unique()->bothify('ENS-#####')),
        ];
    }

    public function vacataire(): static
    {
        return $this->state(fn () => ['grade' => 'Vacataire']);
    }
}
