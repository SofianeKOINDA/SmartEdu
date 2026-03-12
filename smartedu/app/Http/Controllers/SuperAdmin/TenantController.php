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

        return view('super_admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $this->authorize('create', Tenant::class);

        $plans = Plan::where('actif', true)->get();

        return view('super_admin.tenants.create', compact('plans'));
    }

    public function store(StoreTenantRequest $request)
    {
        $this->authorize('create', Tenant::class);

        $tenant = Tenant::create($request->validated());

        return redirect()->route('super_admin.tenants.index')
            ->with('success', 'Université créée avec succès.');
    }

    public function show(Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return view('super_admin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $plans = Plan::where('actif', true)->get();

        return view('super_admin.tenants.edit', compact('tenant', 'plans'));
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
