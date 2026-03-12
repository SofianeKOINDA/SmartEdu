<?php

use App\Http\Controllers\ChefDepartement\EmploiDuTempsController as ChefEmploiDuTempsController;
use App\Http\Controllers\ChefDepartement\PromotionController as ChefPromotionController;
use App\Http\Controllers\ChefDepartement\SeanceController;
use App\Http\Controllers\Doyen\FaculteController;
use App\Http\Controllers\Enseignant\CoursController as EnseignantCoursController;
use App\Http\Controllers\Enseignant\EvaluationController as EnseignantEvaluationController;
use App\Http\Controllers\Enseignant\NoteController as EnseignantNoteController;
use App\Http\Controllers\Enseignant\PresenceController as EnseignantPresenceController;
use App\Http\Controllers\Etudiant\EcheanceController;
use App\Http\Controllers\Etudiant\EmploiDuTempsController as EtudiantEmploiDuTempsController;
use App\Http\Controllers\Recteur\DashboardController as RecteurDashboard;
use App\Http\Controllers\Recteur\TarifController;
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
        Route::resource('tenants', TenantController::class);
    });

// ─── Recteur ─────────────────────────────────────────────────────────────────
Route::prefix('recteur')
    ->middleware(['auth', 'role:recteur'])
    ->name('recteur.')
    ->group(function () {
        Route::get('/dashboard', [RecteurDashboard::class, 'index'])->name('dashboard');
        Route::resource('tarifs', TarifController::class);
    });

// ─── Doyen ───────────────────────────────────────────────────────────────────
Route::prefix('doyen')
    ->middleware(['auth', 'role:doyen'])
    ->name('doyen.')
    ->group(function () {
        Route::resource('facultes', FaculteController::class);
    });

// ─── Chef de département ─────────────────────────────────────────────────────
Route::prefix('chef-departement')
    ->middleware(['auth', 'role:chef_departement'])
    ->name('chef_departement.')
    ->group(function () {
        Route::resource('promotions', ChefPromotionController::class);
        Route::resource('seances', SeanceController::class);

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
        Route::get('/cours', [EnseignantCoursController::class, 'index'])->name('cours.index');
        Route::get('/cours/{cours}', [EnseignantCoursController::class, 'show'])->name('cours.show');

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
        Route::put('/notes/{note}', [EnseignantNoteController::class, 'update'])
            ->name('notes.update');
    });

// ─── Étudiant ────────────────────────────────────────────────────────────────
Route::prefix('etudiant')
    ->middleware(['auth', 'role:etudiant'])
    ->name('etudiant.')
    ->group(function () {
        Route::get('/echeances', [EcheanceController::class, 'index'])
            ->name('echeances.index');
        Route::post('/echeances/{echeance}/payer', [EcheanceController::class, 'payer'])
            ->name('echeances.payer');

        Route::get('/emploi-du-temps', [EtudiantEmploiDuTempsController::class, 'index'])
            ->name('emploi_du_temps.index');
    });
