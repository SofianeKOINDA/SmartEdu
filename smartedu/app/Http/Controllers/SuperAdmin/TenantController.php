<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Plan;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tenant::class);

        $tenants = Tenant::with('plan')->paginate(20);
        $plans   = Plan::where('actif', true)->get();

        return view('super_admin.tenants.liste', compact('tenants', 'plans'));
    }

    public function create()
    {
        return redirect()->route('super_admin.tenants.index');
    }

    public function store(StoreTenantRequest $request)
    {
        $this->authorize('create', Tenant::class);

        Tenant::create($request->validated());

        return redirect()->route('super_admin.tenants.index')
            ->with('success', 'Université créée avec succès.');
    }

    public function show(Tenant $tenant)
    {
        return redirect()->route('super_admin.tenants.index');
    }

    public function edit(Tenant $tenant)
    {
        return redirect()->route('super_admin.tenants.index');
    }

    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $tenant->update($request->validated());

        return redirect()->route('super_admin.tenants.index')
            ->with('success', 'Université mise à jour.');
    }

    public function destroy(Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        $tenant->delete();

        return redirect()->route('super_admin.tenants.index')
            ->with('success', 'Université supprimée.');
    }
}
