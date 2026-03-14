<?php

namespace App\Http\Controllers\Recteur;

use App\Exports\EcheancesExport;
use App\Http\Controllers\Controller;
use App\Models\Echeance;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EcheanceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Echeance::class);

        $echeances = Echeance::with(['etudiant.user', 'tarif.anneeScolaire'])
            ->orderByDesc('date_limite')
            ->paginate(30);

        return view('recteur.echeances.index', compact('echeances'));
    }

    public function export()
    {
        $this->authorize('viewAny', Echeance::class);

        $tenantId = Auth::user()->tenant_id;
        return Excel::download(new EcheancesExport($tenantId), 'echeances.xlsx');
    }
}

