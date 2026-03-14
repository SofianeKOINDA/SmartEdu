<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;

class AbonnementController extends Controller
{
    public function index()
    {
        $abonnements = Abonnement::withoutGlobalScope('tenant')
            ->with(['tenant', 'plan'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('super_admin.abonnements.index', compact('abonnements'));
    }
}

