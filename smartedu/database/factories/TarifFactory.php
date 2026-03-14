<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarifFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'          => Tenant::factory(),
            'annee_scolaire_id'  => AnneeScolaire::factory(),
            'montant_total'      => fake()->randomElement([300000, 450000, 600000, 750000, 1000000]),
            'nombre_echeances'   => 9,
            'jour_limite'        => 5,
            'cree_par'           => User::factory()->recteur(),
        ];
    }
}
