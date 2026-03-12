<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'tenant_id'         => null,
            'nom'               => fake()->lastName(),
            'prenom'            => fake()->firstName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'role'              => 'etudiant',
            'photo_profil'      => null,
            'remember_token'    => Str::random(10),
        ];
    }

    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn () => ['tenant_id' => $tenant->id]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => ['role' => 'super_admin', 'tenant_id' => null]);
    }

    public function recteur(): static
    {
        return $this->state(fn () => ['role' => 'recteur']);
    }

    public function doyen(): static
    {
        return $this->state(fn () => ['role' => 'doyen']);
    }

    public function chefDepartement(): static
    {
        return $this->state(fn () => ['role' => 'chef_departement']);
    }

    public function enseignant(): static
    {
        return $this->state(fn () => ['role' => 'enseignant']);
    }

    public function vacataire(): static
    {
        return $this->state(fn () => ['role' => 'vacataire']);
    }

    public function etudiant(): static
    {
        return $this->state(fn () => ['role' => 'etudiant']);
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }
}
