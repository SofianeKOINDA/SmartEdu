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
use App\Http\Controllers\PayTechController;
use Illuminate\Support\Facades\Route;

// ─── Authentification ─────────────────────────────────────────────────────────
Route::redirect('/', '/login');

require __DIR__.'/auth.php';

// ─── PayTech ──────────────────────────────────────────────────────────────────
// IPN : pas de middleware auth (appelé par les serveurs PayTech)
Route::post('/paytech/ipn', [PayTechController::class, 'ipn'])->name('paytech.ipn');

// Redirections après paiement (etudiant connecté)
Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/paytech/success/{paiement}', [PayTechController::class, 'success'])->name('paytech.success');
    Route::get('/paytech/cancel/{paiement}',  [PayTechController::class, 'cancel'] )->name('paytech.cancel');
});

// ─── Administration ───────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdministrateurController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::put('/profil', [AdministrateurController::class, 'updateProfil'])
        ->name('admin.profil.update');

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
Route::prefix('enseignant')->middleware(['auth', 'role:enseignant'])->group(function () {

    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])
        ->name('enseignant.dashboard');

    // Pages dédiées enseignant
    Route::get('/cours',       [EnseignantController::class, 'mesCours']       )->name('enseignant.cours');
    Route::get('/evaluations', [EnseignantController::class, 'mesEvaluations'] )->name('enseignant.evaluations');
    Route::get('/notes',       [EnseignantController::class, 'mesNotes']       )->name('enseignant.notes');
    Route::get('/presences',   [EnseignantController::class, 'mesPresences']   )->name('enseignant.presences');
    Route::get('/classes',     [EnseignantController::class, 'mesClasses']     )->name('enseignant.classes');
    Route::get('/etudiants',   [EnseignantController::class, 'mesEtudiants']   )->name('enseignant.etudiants');

    Route::put('/profil', [EnseignantController::class, 'updateProfil'])->name('enseignant.profil.update');

    // Gestion classes ↔ cours
    Route::post('/cours/{cours}/classes',                        [EnseignantController::class, 'syncClasses']    )->name('enseignant.cours.classes.sync');

    // Gestion étudiants ↔ classes
    Route::post('/classes/{classe}/etudiants',                   [EnseignantController::class, 'ajouterEtudiant'])->name('enseignant.classe.etudiant.add');
    Route::delete('/classes/{classe}/etudiants/{etudiant}',      [EnseignantController::class, 'retirerEtudiant'])->name('enseignant.classe.etudiant.remove');

    // CRUD Évaluations
    Route::post('/evaluations',                [EvaluationController::class, 'store']  )->name('enseignant.evaluations.store');
    Route::put('/evaluations/{evaluation}',    [EvaluationController::class, 'update'] )->name('enseignant.evaluations.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('enseignant.evaluations.destroy');

    // CRUD Notes
    Route::post('/notes',          [NoteController::class, 'store']  )->name('enseignant.notes.store');
    Route::put('/notes/{note}',    [NoteController::class, 'update'] )->name('enseignant.notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('enseignant.notes.destroy');

    // CRUD Présences
    Route::post('/presences',               [PresenceController::class, 'store']  )->name('enseignant.presences.store');
    Route::put('/presences/{presence}',     [PresenceController::class, 'update'] )->name('enseignant.presences.update');
    Route::delete('/presences/{presence}',  [PresenceController::class, 'destroy'])->name('enseignant.presences.destroy');

});

// ─── Étudiant ─────────────────────────────────────────────────────────────────
Route::prefix('etudiant')->middleware(['auth', 'role:etudiant'])->group(function () {

    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])
        ->name('etudiant.dashboard');

    Route::get('/notes',     [EtudiantController::class, 'mesNotes']    )->name('etudiant.notes');
    Route::get('/cours',     [EtudiantController::class, 'mesCours']    )->name('etudiant.cours');
    Route::get('/presences', [EtudiantController::class, 'mesPresences'])->name('etudiant.presences');
    Route::get('/paiements',                      [EtudiantController::class, 'mesPaiements']   )->name('etudiant.paiements');
    Route::get('/paiements/{paiement}/pay',       [PayTechController::class,  'initiate']       )->name('paytech.initiate');
    Route::get('/classe',    [EtudiantController::class, 'maClasse']    )->name('etudiant.classe');

    Route::put('/profil', [EtudiantController::class, 'updateProfil'])
        ->name('etudiant.profil.update');

});
