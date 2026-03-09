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

// Utilisateurs (table users) — utilise UtilisateurController
Route::resource('users', UtilisateurController::class);

Route::resource('administrateurs', AdministrateurController::class);
Route::resource('classes', ClasseController::class);
Route::resource('enseignants', EnseignantController::class);
Route::resource('etudiants', EtudiantController::class);
Route::resource('cours', CoursController::class);
Route::resource('evaluations', EvaluationController::class);
Route::resource('notes', NoteController::class);
Route::resource('presences', PresenceController::class);
Route::resource('paiements', PaiementController::class);
