<?php

use App\Http\Controllers\ChefDepartement\DashboardController as ChefDashboard;
use App\Http\Controllers\ChefDepartement\EmploiDuTempsController as ChefEmploiDuTempsController;
use App\Http\Controllers\ChefDepartement\PromotionController as ChefPromotionController;
use App\Http\Controllers\ChefDepartement\SeanceController;
use App\Http\Controllers\Doyen\DashboardController as DoyenDashboard;
use App\Http\Controllers\Doyen\FaculteController;
use App\Http\Controllers\Enseignant\CoursController as EnseignantCoursController;
use App\Http\Controllers\Enseignant\DashboardController as EnseignantDashboard;
use App\Http\Controllers\Enseignant\EvaluationController as EnseignantEvaluationController;
use App\Http\Controllers\Enseignant\NoteController as EnseignantNoteController;
use App\Http\Controllers\Enseignant\PresenceController as EnseignantPresenceController;
use App\Http\Controllers\Etudiant\DashboardController as EtudiantDashboard;
use App\Http\Controllers\Etudiant\EcheanceController;
use App\Http\Controllers\Etudiant\EmploiDuTempsController as EtudiantEmploiDuTempsController;
use App\Http\Controllers\Recteur\DashboardController as RecteurDashboard;
use App\Http\Controllers\Recteur\TarifController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Webhooks\PayTechWebhookController;
use Illuminate\Support\Facades\Route;

// ─── Page d'accueil ──────────────────────────────────────────────────────────
Route::redirect('/', '/login');

require __DIR__ . '/auth.php';

// ─── Webhook PayTech (public — CSRF exclu dans bootstrap/app.php) ─────────────
Route::post('/webhooks/paytech', [PayTechWebhookController::class, 'handle'])
    ->name('webhooks.paytech');

// ─── Super Admin ─────────────────────────────────────────────────────────────
Route::prefix('super-admin')
    ->middleware(['auth', 'role:super_admin'])
    ->name('super_admin.')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('tenants', TenantController::class);
        Route::resource('plans', \App\Http\Controllers\SuperAdmin\PlanController::class);
        Route::get('/abonnements', [\App\Http\Controllers\SuperAdmin\AbonnementController::class, 'index'])->name('abonnements.index');
        Route::get('/users', [\App\Http\Controllers\SuperAdmin\UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/desactiver', [\App\Http\Controllers\SuperAdmin\UserController::class, 'desactiver'])->name('users.desactiver');
        Route::put('/users/{user}/password', [\App\Http\Controllers\SuperAdmin\UserController::class, 'resetPassword'])->name('users.password');
        Route::get('/logs', [\App\Http\Controllers\SuperAdmin\LogController::class, 'index'])->name('logs.index');
    });

// ─── Recteur ─────────────────────────────────────────────────────────────────
Route::prefix('recteur')
    ->middleware(['auth', 'role:recteur'])
    ->name('recteur.')
    ->group(function () {
        Route::get('/dashboard', [RecteurDashboard::class, 'index'])->name('dashboard');
        Route::resource('tarifs', TarifController::class);

        Route::resource('facultes', \App\Http\Controllers\Recteur\FaculteController::class);
        Route::resource('departements', \App\Http\Controllers\Recteur\DepartementController::class);
        Route::resource('filieres', \App\Http\Controllers\Recteur\FiliereController::class);
        Route::resource('annees-scolaires', \App\Http\Controllers\Recteur\AnneeScolaireController::class);
        Route::resource('semestres', \App\Http\Controllers\Recteur\SemestreController::class);
        Route::resource('ues', \App\Http\Controllers\Recteur\UEController::class);
        Route::resource('cours', \App\Http\Controllers\Recteur\CoursController::class);
        Route::resource('enseignants', \App\Http\Controllers\Recteur\EnseignantController::class)->only(['index','show','create','store','edit','update']);
        Route::resource('etudiants', \App\Http\Controllers\Recteur\EtudiantController::class)->only(['index','show','create','store','edit','update']);

        Route::get('/echeances', [\App\Http\Controllers\Recteur\EcheanceController::class, 'index'])->name('echeances.index');
        Route::get('/echeances/export', [\App\Http\Controllers\Recteur\EcheanceController::class, 'export'])->name('echeances.export');
        Route::get('/transactions', [\App\Http\Controllers\Recteur\TransactionController::class, 'index'])->name('transactions.index');
    });

// ─── Doyen ───────────────────────────────────────────────────────────────────
Route::prefix('doyen')
    ->middleware(['auth', 'role:doyen'])
    ->name('doyen.')
    ->group(function () {
        Route::get('/dashboard', [DoyenDashboard::class, 'index'])->name('dashboard');
        Route::resource('facultes', FaculteController::class);

        Route::resource('departements', \App\Http\Controllers\Doyen\DepartementController::class);
        Route::get('/enseignants', [\App\Http\Controllers\Doyen\EnseignantController::class, 'index'])->name('enseignants.index');
        Route::get('/enseignants/{enseignant}', [\App\Http\Controllers\Doyen\EnseignantController::class, 'show'])->name('enseignants.show');
        Route::get('/etudiants', [\App\Http\Controllers\Doyen\EtudiantController::class, 'index'])->name('etudiants.index');
        Route::get('/etudiants/{etudiant}', [\App\Http\Controllers\Doyen\EtudiantController::class, 'show'])->name('etudiants.show');
        Route::get('/deliberations', [\App\Http\Controllers\Doyen\DeliberationController::class, 'index'])->name('deliberations.index');
        Route::post('/deliberations/lancer', [\App\Http\Controllers\Doyen\DeliberationController::class, 'lancer'])->name('deliberations.lancer');
        Route::get('/demandes', [\App\Http\Controllers\Doyen\DemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes/{demande}', [\App\Http\Controllers\Doyen\DemandeController::class, 'show'])->name('demandes.show');
        Route::put('/demandes/{demande}', [\App\Http\Controllers\Doyen\DemandeController::class, 'update'])->name('demandes.update');
        Route::get('/demandes/{demande}/download', [\App\Http\Controllers\Doyen\DemandeController::class, 'download'])->name('demandes.download');
    });

// ─── Chef de département ─────────────────────────────────────────────────────
Route::prefix('chef-departement')
    ->middleware(['auth', 'role:chef_departement'])
    ->name('chef_departement.')
    ->group(function () {
        Route::get('/dashboard', [ChefDashboard::class, 'index'])->name('dashboard');
        Route::resource('promotions', ChefPromotionController::class);
        Route::resource('seances', SeanceController::class);
        Route::resource('etudiants', \App\Http\Controllers\ChefDepartement\EtudiantController::class);
        Route::resource('enseignants', \App\Http\Controllers\ChefDepartement\EnseignantController::class);
        Route::resource('filieres', \App\Http\Controllers\ChefDepartement\FiliereController::class);
        Route::resource('ues', \App\Http\Controllers\ChefDepartement\UEController::class);
        Route::resource('cours', \App\Http\Controllers\ChefDepartement\CoursController::class);

        Route::get('/demandes', [\App\Http\Controllers\ChefDepartement\DemandeController::class, 'index'])
            ->name('demandes.index');
        Route::get('/demandes/{demande}', [\App\Http\Controllers\ChefDepartement\DemandeController::class, 'show'])
            ->name('demandes.show');
        Route::put('/demandes/{demande}', [\App\Http\Controllers\ChefDepartement\DemandeController::class, 'update'])
            ->name('demandes.update');
        Route::get('/demandes/{demande}/download', [\App\Http\Controllers\ChefDepartement\DemandeController::class, 'download'])
            ->name('demandes.download');

        Route::get('/emploi-du-temps', [ChefEmploiDuTempsController::class, 'index'])
            ->name('emploi_du_temps.index');
        Route::get('/emploi-du-temps/{promotion}', [ChefEmploiDuTempsController::class, 'show'])
            ->name('emploi_du_temps.show');
    });

// ─── Enseignant / Vacataire ───────────────────────────────────────────────────
Route::prefix('enseignant')
    ->middleware(['auth', 'role:enseignant,vacataire'])
    ->name('enseignant.')
    ->group(function () {
        Route::get('/dashboard', [EnseignantDashboard::class, 'index'])->name('dashboard');
        Route::get('/cours', [EnseignantCoursController::class, 'index'])->name('cours.index');
        Route::get('/cours/{cours}', [EnseignantCoursController::class, 'show'])->name('cours.show');

        Route::get('/emploi-du-temps', [\App\Http\Controllers\Enseignant\EmploiDuTempsController::class, 'index'])
            ->name('emploi_du_temps.index');

        Route::get('/cours/{cours}/presences', [EnseignantPresenceController::class, 'index'])
            ->name('presences.index');
        Route::get('/cours/{cours}/presences/create', [EnseignantPresenceController::class, 'create'])
            ->name('presences.create');
        Route::post('/presences', [EnseignantPresenceController::class, 'store'])
            ->name('presences.store');
        Route::put('/presences/{presence}', [EnseignantPresenceController::class, 'update'])
            ->name('presences.update');

        Route::get('/cours/{cours}/evaluations', [EnseignantEvaluationController::class, 'index'])
            ->name('evaluations.index');
        Route::get('/cours/{cours}/evaluations/create', [EnseignantEvaluationController::class, 'create'])
            ->name('evaluations.create');
        Route::post('/evaluations', [EnseignantEvaluationController::class, 'store'])
            ->name('evaluations.store');
        Route::get('/evaluations/{evaluation}/edit', [EnseignantEvaluationController::class, 'edit'])
            ->name('evaluations.edit');
        Route::put('/evaluations/{evaluation}', [EnseignantEvaluationController::class, 'update'])
            ->name('evaluations.update');
        Route::delete('/evaluations/{evaluation}', [EnseignantEvaluationController::class, 'destroy'])
            ->name('evaluations.destroy');

        Route::get('/evaluations/{evaluation}/notes', [EnseignantNoteController::class, 'index'])
            ->name('notes.index');
        Route::get('/evaluations/{evaluation}/notes/create', [EnseignantNoteController::class, 'create'])
            ->name('notes.create');
        Route::post('/notes', [EnseignantNoteController::class, 'store'])
            ->name('notes.store');
        Route::post('/evaluations/{evaluation}/notes/import', [EnseignantNoteController::class, 'import'])
            ->name('notes.import');
        Route::put('/notes/{note}', [EnseignantNoteController::class, 'update'])
            ->name('notes.update');
    });

// ─── Étudiant ────────────────────────────────────────────────────────────────
Route::prefix('etudiant')
    ->middleware(['auth', 'role:etudiant'])
    ->name('etudiant.')
    ->group(function () {
        Route::get('/dashboard', [EtudiantDashboard::class, 'index'])
            ->name('dashboard');
        Route::get('/cours', [\App\Http\Controllers\Etudiant\CoursController::class, 'index'])
            ->name('cours.index');
        Route::get('/cours/{cours}', [\App\Http\Controllers\Etudiant\CoursController::class, 'show'])
            ->name('cours.show');
        Route::get('/notes', [\App\Http\Controllers\Etudiant\NoteController::class, 'index'])
            ->name('notes.index');
        Route::get('/evaluations', [\App\Http\Controllers\Etudiant\EvaluationController::class, 'index'])
            ->name('evaluations.index');
        Route::get('/presences', [\App\Http\Controllers\Etudiant\PresenceController::class, 'index'])
            ->name('presences.index');
        Route::get('/demandes', [\App\Http\Controllers\Etudiant\DemandeController::class, 'index'])
            ->name('demandes.index');
        Route::post('/demandes', [\App\Http\Controllers\Etudiant\DemandeController::class, 'store'])
            ->name('demandes.store');
        Route::get('/demandes/{demande}/download', [\App\Http\Controllers\Etudiant\DemandeController::class, 'download'])
            ->name('demandes.download');
        Route::delete('/demandes/{demande}', [\App\Http\Controllers\Etudiant\DemandeController::class, 'destroy'])
            ->name('demandes.destroy');
        Route::get('/resultats', [\App\Http\Controllers\Etudiant\ResultatController::class, 'index'])
            ->name('resultats.index');
        Route::get('/echeances', [EcheanceController::class, 'index'])
            ->name('echeances.index');
        Route::post('/echeances/{echeance}/payer', [EcheanceController::class, 'payer'])
            ->name('echeances.payer');
        Route::get('/emploi-du-temps', [EtudiantEmploiDuTempsController::class, 'index'])
            ->name('emploi_du_temps.index');
    });
