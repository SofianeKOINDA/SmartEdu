<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Faculte;

class DashboardController extends Controller
{
    public function index()
    {
        $tenantId = auth()->user()->tenant_id;

        $nbFacultes     = Faculte::where('tenant_id', $tenantId)->count();
        $nbDepartements = Departement::where('tenant_id', $tenantId)->count();
        $nbEnseignants  = Enseignant::where('tenant_id', $tenantId)->count();
        $nbEtudiants    = Etudiant::where('tenant_id', $tenantId)->count();

        $facultes = Faculte::with('departements')
            ->where('tenant_id', $tenantId)
            ->limit(5)
            ->get();

        return view('doyen', compact(
            'nbFacultes',
            'nbDepartements',
            'nbEnseignants',
            'nbEtudiants',
            'facultes'
        ));
    }
}
