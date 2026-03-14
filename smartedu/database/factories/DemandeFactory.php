<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'etudiant_id' => Etudiant::factory(),
            'type'        => fake()->randomElement(['attestation', 'releve_notes', 'certificat', 'autre']),
            'statut'      => 'en_attente',
            'motif'       => fake()->optional(0.6)->sentence(),
            'reponse'     => null,
            'traite_par'  => null,
            'traite_le'   => null,
        ];
    }

    public function traitee(): static
    {
        return $this->state(fn () => [
            'statut'     => 'traitee',
            'reponse'    => 'Votre demande a été traitée.',
            'traite_par' => \App\Models\User::factory()->chefDepartement(),
            'traite_le'  => now(),
        ]);
    }
}
