<?php

namespace Database\Seeders;

use App\Models\AnneeScolaire;
use App\Models\Cours;
use App\Models\Departement;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\InscriptionPedagogique;
use App\Models\Plan;
use App\Models\Promotion;
use App\Models\Semestre;
use App\Models\Tarif;
use App\Models\Tenant;
use App\Models\UE;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Plan ────────────────────────────────────────────────────────────────
        $plan = Plan::create([
            'nom'             => 'Pro',
            'description'     => 'Plan professionnel pour universités moyennes',
            'prix_mensuel'    => 59900,
            'max_etudiants'   => 2000,
            'max_enseignants' => 200,
            'actif'           => true,
        ]);

        // ─── Tenant (Université de test) ─────────────────────────────────────────
        $tenant = Tenant::create([
            'plan_id'   => $plan->id,
            'nom'       => 'Université Cheikh Anta Diop',
            'slug'      => 'ucad-test',
            'email'     => 'contact@ucad-test.sn',
            'telephone' => '+221 33 000 0000',
            'adresse'   => 'Dakar, Sénégal',
            'actif'     => true,
        ]);

        // ─── Super Admin (pas de tenant) ─────────────────────────────────────────
        User::create([
            'tenant_id'         => null,
            'nom'               => 'KOINDA',
            'prenom'            => 'Benewende Sofiane',
            'email'             => 'superadmin@smartedu.com',
            'password'          => Hash::make('password'),
            'role'              => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // ─── Recteur ─────────────────────────────────────────────────────────────
        $recteurUser = User::create([
            'tenant_id'         => $tenant->id,
            'nom'               => 'Diallo',
            'prenom'            => 'Mamadou',
            'email'             => 'recteur@ucad-test.sn',
            'password'          => Hash::make('password'),
            'role'              => 'recteur',
            'email_verified_at' => now(),
        ]);

        // ─── Faculté ─────────────────────────────────────────────────────────────
        $faculte = Faculte::create([
            'tenant_id'   => $tenant->id,
            'nom'         => 'Faculté des Sciences et Technologies',
            'code'        => 'FST',
            'description' => 'Sciences exactes, ingénierie et technologie',
        ]);

        // ─── Département ─────────────────────────────────────────────────────────
        $departement = Departement::create([
            'tenant_id'  => $tenant->id,
            'faculte_id' => $faculte->id,
            'nom'        => 'Informatique',
            'code'       => 'INFO',
        ]);

        // ─── Doyen ───────────────────────────────────────────────────────────────
        User::create([
            'tenant_id'         => $tenant->id,
            'nom'               => 'Ndiaye',
            'prenom'            => 'Oumar',
            'email'             => 'doyen@ucad-test.sn',
            'password'          => Hash::make('password'),
            'role'              => 'doyen',
            'email_verified_at' => now(),
        ]);

        // ─── Chef de département ─────────────────────────────────────────────────
        User::create([
            'tenant_id'         => $tenant->id,
            'nom'               => 'Sarr',
            'prenom'            => 'Ibrahima',
            'email'             => 'chef@ucad-test.sn',
            'password'          => Hash::make('password'),
            'role'              => 'chef_departement',
            'email_verified_at' => now(),
        ]);

        // ─── Filière ─────────────────────────────────────────────────────────────
        $filiere = Filiere::create([
            'tenant_id'      => $tenant->id,
            'departement_id' => $departement->id,
            'nom'            => 'Licence Informatique',
            'code'           => 'LINF',
            'duree_annees'   => 3,
        ]);

        // ─── Année scolaire ──────────────────────────────────────────────────────
        $annee = AnneeScolaire::create([
            'tenant_id'  => $tenant->id,
            'libelle'    => '2025-2026',
            'date_debut' => '2025-09-01',
            'date_fin'   => '2026-07-31',
            'courante'   => true,
        ]);

        // ─── Promotion ───────────────────────────────────────────────────────────
        $promotion = Promotion::create([
            'tenant_id'         => $tenant->id,
            'filiere_id'        => $filiere->id,
            'annee_scolaire_id' => $annee->id,
            'nom'               => 'L1 Info 2025-2026',
            'niveau'            => 1,
        ]);

        // ─── Semestres ───────────────────────────────────────────────────────────
        $semestre1 = Semestre::create([
            'tenant_id'         => $tenant->id,
            'annee_scolaire_id' => $annee->id,
            'nom'               => 'Semestre 1',
            'numero'            => 1,
            'date_debut'        => '2025-09-01',
            'date_fin'          => '2026-01-31',
            'actif'             => true,
        ]);

        $semestre2 = Semestre::create([
            'tenant_id'         => $tenant->id,
            'annee_scolaire_id' => $annee->id,
            'nom'               => 'Semestre 2',
            'numero'            => 2,
            'date_debut'        => '2026-02-01',
            'date_fin'          => '2026-06-30',
            'actif'             => false,
        ]);

        // ─── UE ──────────────────────────────────────────────────────────────────
        $ue1 = UE::create([
            'tenant_id'   => $tenant->id,
            'semestre_id' => $semestre1->id,
            'nom'         => 'Algorithmique',
            'code'        => 'ALGO1',
            'coefficient' => 3,
            'credit'      => 6,
        ]);

        $ue2 = UE::create([
            'tenant_id'   => $tenant->id,
            'semestre_id' => $semestre1->id,
            'nom'         => 'Mathématiques',
            'code'        => 'MATH1',
            'coefficient' => 2,
            'credit'      => 4,
        ]);

        // ─── Enseignant ──────────────────────────────────────────────────────────
        $enseignantUser = User::create([
            'tenant_id'         => $tenant->id,
            'nom'               => 'Koné',
            'prenom'            => 'Ibrahim',
            'email'             => 'enseignant@ucad-test.sn',
            'password'          => Hash::make('password'),
            'role'              => 'enseignant',
            'email_verified_at' => now(),
        ]);
        $enseignant = Enseignant::create([
            'tenant_id'      => $tenant->id,
            'user_id'        => $enseignantUser->id,
            'departement_id' => $departement->id,
            'grade'          => 'Maître de Conférences',
            'specialite'     => 'Algorithmique et Structures de Données',
            'bureau'         => 'B204',
            'matricule'      => 'ENS-001',
        ]);

        // ─── Cours ───────────────────────────────────────────────────────────────
        $cours1 = Cours::create([
            'tenant_id'      => $tenant->id,
            'ue_id'          => $ue1->id,
            'enseignant_id'  => $enseignant->id,
            'intitule'       => 'Algorithmique et Structures de Données',
            'code'           => 'ASD101',
            'coefficient'    => 3,
            'volume_horaire' => 45,
        ]);

        $cours2 = Cours::create([
            'tenant_id'      => $tenant->id,
            'ue_id'          => $ue2->id,
            'enseignant_id'  => $enseignant->id,
            'intitule'       => 'Mathématiques Discrètes',
            'code'           => 'MTH101',
            'coefficient'    => 2,
            'volume_horaire' => 30,
        ]);

        // ─── Évaluations ─────────────────────────────────────────────────────────
        $eval1 = Evaluation::create([
            'tenant_id'       => $tenant->id,
            'cours_id'        => $cours1->id,
            'intitule'        => 'Devoir 1',
            'type'            => 'devoir',
            'coefficient'     => 1,
            'note_max'        => 20,
            'date_evaluation' => '2025-10-15',
        ]);

        $eval2 = Evaluation::create([
            'tenant_id'       => $tenant->id,
            'cours_id'        => $cours1->id,
            'intitule'        => 'Examen Final S1',
            'type'            => 'examen',
            'coefficient'     => 3,
            'note_max'        => 20,
            'date_evaluation' => '2026-01-20',
        ]);

        // ─── Étudiants (3) ───────────────────────────────────────────────────────
        $etudiants = [];
        $etudiantData = [
            ['nom' => 'Traoré', 'prenom' => 'Fatima', 'email' => 'etudiant@ucad-test.sn', 'num' => 'ETU-2025-001'],
            ['nom' => 'Diop',   'prenom' => 'Cheikh', 'email' => 'cheikh.diop@ucad-test.sn', 'num' => 'ETU-2025-002'],
            ['nom' => 'Fall',   'prenom' => 'Aïssatou', 'email' => 'aissatou.fall@ucad-test.sn', 'num' => 'ETU-2025-003'],
        ];

        foreach ($etudiantData as $data) {
            $user = User::create([
                'tenant_id'         => $tenant->id,
                'nom'               => $data['nom'],
                'prenom'            => $data['prenom'],
                'email'             => $data['email'],
                'password'          => Hash::make('password'),
                'role'              => 'etudiant',
                'email_verified_at' => now(),
            ]);

            // withoutEvents pour éviter le déclenchement auto des échéances (pas de tarif encore)
            $etudiant = Etudiant::withoutEvents(fn () => Etudiant::create([
                'tenant_id'        => $tenant->id,
                'user_id'          => $user->id,
                'promotion_id'     => $promotion->id,
                'numero_etudiant'  => $data['num'],
                'date_naissance'   => '2004-06-15',
                'lieu_naissance'   => 'Dakar',
                'nationalite'      => 'Sénégalaise',
                'actif'            => true,
            ]));

            $etudiants[] = $etudiant;

            // Inscription pédagogique aux deux cours
            InscriptionPedagogique::create([
                'tenant_id'        => $tenant->id,
                'etudiant_id'      => $etudiant->id,
                'cours_id'         => $cours1->id,
                'date_inscription' => '2025-09-05',
            ]);
            InscriptionPedagogique::create([
                'tenant_id'        => $tenant->id,
                'etudiant_id'      => $etudiant->id,
                'cours_id'         => $cours2->id,
                'date_inscription' => '2025-09-05',
            ]);
        }

        // ─── Tarif (déclenche la génération auto des échéances) ──────────────────
        // On crée le tarif APRÈS les étudiants : EcheanceService::genererPourTousLesEtudiants()
        // sera appelé via l'event Tarif::created
        Tarif::create([
            'tenant_id'         => $tenant->id,
            'annee_scolaire_id' => $annee->id,
            'montant_total'     => 450000,
            'nombre_echeances'  => 9,
            'jour_limite'       => 5,
            'cree_par'          => $recteurUser->id,
        ]);

        // ─── Notes pour le premier étudiant ──────────────────────────────────────
        $premierEtudiant = $etudiants[0];
        \App\Models\Note::create([
            'tenant_id'     => $tenant->id,
            'evaluation_id' => $eval1->id,
            'etudiant_id'   => $premierEtudiant->id,
            'saisi_par'     => $enseignantUser->id,
            'valeur'        => 14.5,
        ]);
        \App\Models\Note::create([
            'tenant_id'     => $tenant->id,
            'evaluation_id' => $eval2->id,
            'etudiant_id'   => $premierEtudiant->id,
            'saisi_par'     => $enseignantUser->id,
            'valeur'        => 12,
        ]);

        $this->command->info('✅ Tenant "UCAD" seedé avec succès.');
        $this->command->info('   superadmin@smartedu.com / password');
        $this->command->info('   recteur@ucad-test.sn / password');
        $this->command->info('   enseignant@ucad-test.sn / password');
        $this->command->info('   etudiant@ucad-test.sn / password');
    }
}
