<?php

namespace Database\Factories;

use App\Models\Enseignant;
use App\Models\Tenant;
use App\Models\UE;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoursFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'      => Tenant::factory(),
            'ue_id'          => UE::factory(),
            'enseignant_id'  => null,
            'intitule'       => fake()->randomElement([
                'Algorithmique et Structures de Données',
                'Programmation Orientée Objet',
                'Bases de Données',
                'Réseaux Informatiques',
                'Intelligence Artificielle',
                'Mathématiques Discrètes',
                'Analyse Numérique',
                'Systèmes d\'Exploitation',
                'Développement Web',
                'Génie Logiciel',
            ]),
            'code'           => strtoupper(fake()->unique()->lexify('CRS???')),
            'coefficient'    => fake()->randomElement([1, 1.5, 2]),
            'volume_horaire' => fake()->randomElement([20, 30, 45, 60]),
        ];
    }

    public function avecEnseignant(Enseignant $enseignant): static
    {
        return $this->state(fn () => ['enseignant_id' => $enseignant->id]);
    }
}
