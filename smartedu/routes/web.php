<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

// ─── Dashboards par rôle ──────────────────────────────────────────────────────
Route::get('/admin/dashboard',      [AdministrateurController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/enseignant/dashboard', [EnseignantController::class,     'dashboard'])->name('enseignant.dashboard');
Route::get('/etudiant/dashboard',   [EtudiantController::class,       'dashboard'])->name('etudiant.dashboard');

// ─── Profil étudiant ──────────────────────────────────────────────────────────
Route::put('/etudiant/profil', [EtudiantController::class, 'updateProfil'])->name('etudiant.profil.update');

// ─── CRUD via modals (pas de routes create/edit) ──────────────────────────────

// Utilisateurs
Route::resource('users', UtilisateurController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Administrateurs
Route::resource('administrateurs', AdministrateurController::class)
    ->only(['store', 'update', 'destroy']);

// Classes
Route::resource('classes', ClasseController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

// Enseignants
Route::resource('enseignants', EnseignantController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Étudiants
Route::resource('etudiants', EtudiantController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Cours
Route::resource('cours', CoursController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

// Évaluations
Route::resource('evaluations', EvaluationController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

// Notes
Route::resource('notes', NoteController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Présences
Route::resource('presences', PresenceController::class)
    ->only(['index', 'store', 'update', 'destroy']);

// Paiements
Route::resource('paiements', PaiementController::class)
    ->only(['index', 'store', 'update', 'destroy']);
