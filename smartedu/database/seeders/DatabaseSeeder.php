<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Classe de test ───────────────────────────────────────────────────
        $classe = Classe::create([
            'nom'           => 'Terminale A',
            'niveau'        => 'Terminale',
            'annee_scolaire'=> '2025-2026',
        ]);

        // ─── Administrateur ───────────────────────────────────────────────────
        $adminUser = User::create([
            'nom'               => 'Diallo',
            'prenom'            => 'Mamadou',
            'email'             => 'admin@smartedu.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);
        Administrateur::create([
            'user_id'                  => $adminUser->id,
            'departement'              => 'Direction Générale',
            'telephone'                => '0600000001',
            'matricule_administrateur' => 'ADM-001',
        ]);

        // ─── Enseignant ───────────────────────────────────────────────────────
        $enseignantUser = User::create([
            'nom'               => 'Koné',
            'prenom'            => 'Ibrahim',
            'email'             => 'enseignant@smartedu.com',
            'password'          => Hash::make('password'),
            'role'              => 'enseignant',
            'email_verified_at' => now(),
        ]);
        Enseignant::create([
            'user_id'              => $enseignantUser->id,
            'specialite'           => 'Mathématiques',
            'telephone'            => '0600000002',
            'matricule_enseignant' => 'ENS-001',
        ]);

        // ─── Étudiant ─────────────────────────────────────────────────────────
        $etudiantUser = User::create([
            'nom'               => 'Traoré',
            'prenom'            => 'Fatima',
            'email'             => 'etudiant@smartedu.com',
            'password'          => Hash::make('password'),
            'role'              => 'etudiant',
            'email_verified_at' => now(),
        ]);
        Etudiant::create([
            'user_id'        => $etudiantUser->id,
            'matricule'      => 'ETU-0001',
            'date_naissance' => '2002-05-15',
            'classe_id'      => $classe->id,
        ]);
    }
}
