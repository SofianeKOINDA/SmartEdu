<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Tenant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $nbTenants       = Tenant::count();
        $nbUsersTotal    = User::count();
        $nbAbonnements   = Abonnement::where('statut', 'actif')->count();

        $recentsTenants = Tenant::with('abonnements.plan')
            ->latest()
            ->limit(5)
            ->get();

        return view('super_admin', compact(
            'nbTenants',
            'nbUsersTotal',
            'nbAbonnements',
            'recentsTenants'
        ));
    }
}
