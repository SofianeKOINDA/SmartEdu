<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Promotion;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeanceFactory extends Factory
{
    public function definition(): array
    {
        $heure = fake()->randomElement(['08:00', '09:30', '11:00', '13:30', '15:00', '16:30']);

        return [
            'tenant_id'       => Tenant::factory(),
            'cours_id'        => Cours::factory(),
            'promotion_id'    => Promotion::factory(),
            'salle'           => fake()->optional(0.8)->regexify('[A-C][0-9]{3}'),
            'jour'            => fake()->randomElement(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']),
            'heure_debut'     => $heure,
            'heure_fin'       => date('H:i', strtotime($heure . ' +1 hour 30 minutes')),
            'type'            => fake()->randomElement(['cm', 'td', 'tp']),
            'recurrent'       => true,
            'date_specifique' => null,
        ];
    }

    public function ponctuelle(): static
    {
        return $this->state(fn () => [
            'recurrent'       => false,
            'date_specifique' => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
        ]);
    }
}
