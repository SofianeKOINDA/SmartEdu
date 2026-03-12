<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Faculte;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('view', auth()->user()->tenant);

        $stats = [
            'facultes'    => Faculte::count(),
            'enseignants' => Enseignant::count(),
            'etudiants'   => Etudiant::where('actif', true)->count(),
        ];

        return view('recteur.dashboard', compact('stats'));
    }
}
