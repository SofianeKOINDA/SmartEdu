<?php

namespace Database\Factories;

use App\Models\Promotion;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'         => Tenant::factory(),
            'user_id'           => User::factory()->etudiant(),
            'promotion_id'      => Promotion::factory(),
            'numero_etudiant'   => strtoupper(fake()->unique()->bothify('ETU-#####')),
            'date_naissance'    => fake()->dateTimeBetween('-30 years', '-17 years')->format('Y-m-d'),
            'lieu_naissance'    => fake()->city(),
            'nationalite'       => 'Sénégalaise',
            'actif'             => true,
        ];
    }

    public function inactif(): static
    {
        return $this->state(fn () => ['actif' => false]);
    }
}
