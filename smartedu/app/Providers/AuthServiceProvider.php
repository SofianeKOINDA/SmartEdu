<?php

namespace App\Providers;

use App\Models\AnneeScolaire;
use App\Models\Cours;
use App\Models\Deliberation;
use App\Models\Demande;
use App\Models\Departement;
use App\Models\Echeance;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Note;
use App\Models\Presence;
use App\Models\Promotion;
use App\Models\Seance;
use App\Models\Semestre;
use App\Models\Tarif;
use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\UE;
use App\Policies\AnneeScolairePolicy;
use App\Policies\CoursPolicy;
use App\Policies\DeliberationPolicy;
use App\Policies\DemandePolicy;
use App\Policies\DepartementPolicy;
use App\Policies\EcheancePolicy;
use App\Policies\EnseignantPolicy;
use App\Policies\EtudiantPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\FacultePolicy;
use App\Policies\FilierePolicy;
use App\Policies\NotePolicy;
use App\Policies\PresencePolicy;
use App\Policies\PromotionPolicy;
use App\Policies\SeancePolicy;
use App\Policies\SemestrePolicy;
use App\Policies\TarifPolicy;
use App\Policies\TenantPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UEPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Tenant::class        => TenantPolicy::class,
        Faculte::class       => FacultePolicy::class,
        Departement::class   => DepartementPolicy::class,
        Filiere::class       => FilierePolicy::class,
        AnneeScolaire::class => AnneeScolairePolicy::class,
        Promotion::class     => PromotionPolicy::class,
        Semestre::class      => SemestrePolicy::class,
        UE::class            => UEPolicy::class,
        Enseignant::class    => EnseignantPolicy::class,
        Etudiant::class      => EtudiantPolicy::class,
        Cours::class         => CoursPolicy::class,
        Evaluation::class    => EvaluationPolicy::class,
        Note::class          => NotePolicy::class,
        Presence::class      => PresencePolicy::class,
        Tarif::class         => TarifPolicy::class,
        Echeance::class      => EcheancePolicy::class,        Transaction::class    => TransactionPolicy::class,        Seance::class        => SeancePolicy::class,
        Deliberation::class  => DeliberationPolicy::class,
        Demande::class       => DemandePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
