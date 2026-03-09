<?php

use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;

// ─── Authentification ─────────────────────────────────────────────────────────
Route::redirect('/', '/login');

require __DIR__.'/auth.php';

// ─── Administration ───────────────────────────────────────────────────────────
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', [AdministrateurController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Utilisateurs
    Route::get('/users',                   [UtilisateurController::class,    'index']  )->name('users.index');
    Route::post('/users',                  [UtilisateurController::class,    'store']  )->name('users.store');
    Route::put('/users/{user}',            [UtilisateurController::class,    'update'] )->name('users.update');
    Route::delete('/users/{user}',         [UtilisateurController::class,    'destroy'])->name('users.destroy');

    // Administrateurs
    Route::post('/administrateurs',                      [AdministrateurController::class, 'store']  )->name('administrateurs.store');
    Route::put('/administrateurs/{administrateur}',      [AdministrateurController::class, 'update'] )->name('administrateurs.update');
    Route::delete('/administrateurs/{administrateur}',   [AdministrateurController::class, 'destroy'])->name('administrateurs.destroy');

    // Classes
    Route::get('/classes',               [ClasseController::class, 'index']  )->name('classes.index');
    Route::get('/classes/{classe}',      [ClasseController::class, 'show']   )->name('classes.show');
    Route::post('/classes',              [ClasseController::class, 'store']  )->name('classes.store');
    Route::put('/classes/{classe}',      [ClasseController::class, 'update'] )->name('classes.update');
    Route::delete('/classes/{classe}',   [ClasseController::class, 'destroy'])->name('classes.destroy');

    // Enseignants
    Route::get('/enseignants',                 [EnseignantController::class, 'index']  )->name('enseignants.index');
    Route::post('/enseignants',                [EnseignantController::class, 'store']  )->name('enseignants.store');
    Route::put('/enseignants/{enseignant}',    [EnseignantController::class, 'update'] )->name('enseignants.update');
    Route::delete('/enseignants/{enseignant}', [EnseignantController::class, 'destroy'])->name('enseignants.destroy');

    // Étudiants
    Route::get('/etudiants',               [EtudiantController::class, 'index']  )->name('etudiants.index');
    Route::post('/etudiants',              [EtudiantController::class, 'store']  )->name('etudiants.store');
    Route::put('/etudiants/{etudiant}',    [EtudiantController::class, 'update'] )->name('etudiants.update');
    Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');

    // Cours
    Route::get('/cours',             [CoursController::class, 'index']  )->name('cours.index');
    Route::get('/cours/{cours}',     [CoursController::class, 'show']   )->name('cours.show');
    Route::post('/cours',            [CoursController::class, 'store']  )->name('cours.store');
    Route::put('/cours/{cours}',     [CoursController::class, 'update'] )->name('cours.update');
    Route::delete('/cours/{cours}',  [CoursController::class, 'destroy'])->name('cours.destroy');

    // Évaluations
    Route::get('/evaluations',                   [EvaluationController::class, 'index']  )->name('evaluations.index');
    Route::get('/evaluations/{evaluation}',      [EvaluationController::class, 'show']   )->name('evaluations.show');
    Route::post('/evaluations',                  [EvaluationController::class, 'store']  )->name('evaluations.store');
    Route::put('/evaluations/{evaluation}',      [EvaluationController::class, 'update'] )->name('evaluations.update');
    Route::delete('/evaluations/{evaluation}',   [EvaluationController::class, 'destroy'])->name('evaluations.destroy');

    // Notes
    Route::get('/notes',              [NoteController::class, 'index']  )->name('notes.index');
    Route::post('/notes',             [NoteController::class, 'store']  )->name('notes.store');
    Route::put('/notes/{note}',       [NoteController::class, 'update'] )->name('notes.update');
    Route::delete('/notes/{note}',    [NoteController::class, 'destroy'])->name('notes.destroy');

    // Présences
    Route::get('/presences',                [PresenceController::class, 'index']  )->name('presences.index');
    Route::post('/presences',               [PresenceController::class, 'store']  )->name('presences.store');
    Route::put('/presences/{presence}',     [PresenceController::class, 'update'] )->name('presences.update');
    Route::delete('/presences/{presence}',  [PresenceController::class, 'destroy'])->name('presences.destroy');

    // Paiements
    Route::get('/paiements',                [PaiementController::class, 'index']  )->name('paiements.index');
    Route::post('/paiements',               [PaiementController::class, 'store']  )->name('paiements.store');
    Route::put('/paiements/{paiement}',     [PaiementController::class, 'update'] )->name('paiements.update');
    Route::delete('/paiements/{paiement}',  [PaiementController::class, 'destroy'])->name('paiements.destroy');

});

// ─── Enseignant ───────────────────────────────────────────────────────────────
Route::prefix('enseignant')->middleware('auth')->group(function () {

    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])
        ->name('enseignant.dashboard');

    // Évaluations (l'enseignant crée/modifie ses propres évaluations)
    Route::post('/evaluations',                [EvaluationController::class, 'store']  )->name('enseignant.evaluations.store');
    Route::put('/evaluations/{evaluation}',    [EvaluationController::class, 'update'] )->name('enseignant.evaluations.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('enseignant.evaluations.destroy');

    // Notes (l'enseignant attribue les notes)
    Route::post('/notes',          [NoteController::class, 'store']  )->name('enseignant.notes.store');
    Route::put('/notes/{note}',    [NoteController::class, 'update'] )->name('enseignant.notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('enseignant.notes.destroy');

    // Présences (l'enseignant saisit les présences)
    Route::post('/presences',               [PresenceController::class, 'store']  )->name('enseignant.presences.store');
    Route::put('/presences/{presence}',     [PresenceController::class, 'update'] )->name('enseignant.presences.update');
    Route::delete('/presences/{presence}',  [PresenceController::class, 'destroy'])->name('enseignant.presences.destroy');

});

// ─── Étudiant ─────────────────────────────────────────────────────────────────
Route::prefix('etudiant')->middleware('auth')->group(function () {

    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])
        ->name('etudiant.dashboard');

    Route::put('/profil', [EtudiantController::class, 'updateProfil'])
        ->name('etudiant.profil.update');

});
