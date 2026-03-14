<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderByDesc('created_at')->paginate(20);
        return view('super_admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super_admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix_mensuel' => ['required', 'numeric', 'min:0'],
            'max_etudiants' => ['nullable', 'integer', 'min:0'],
            'max_enseignants' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
        ]);

        Plan::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'prix_mensuel' => $data['prix_mensuel'],
            'max_etudiants' => $data['max_etudiants'] ?? null,
            'max_enseignants' => $data['max_enseignants'] ?? null,
            'actif' => (bool) ($data['actif'] ?? true),
        ]);

        return redirect()->route('super_admin.plans.index')->with('success', 'Plan créé.');
    }

    public function show(Plan $plan)
    {
        return redirect()->route('super_admin.plans.edit', $plan);
    }

    public function edit(Plan $plan)
    {
        return view('super_admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix_mensuel' => ['required', 'numeric', 'min:0'],
            'max_etudiants' => ['nullable', 'integer', 'min:0'],
            'max_enseignants' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $plan->update([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'prix_mensuel' => $data['prix_mensuel'],
            'max_etudiants' => $data['max_etudiants'] ?? null,
            'max_enseignants' => $data['max_enseignants'] ?? null,
            'actif' => (bool) ($data['actif'] ?? false),
        ]);

        return redirect()->route('super_admin.plans.index')->with('success', 'Plan mis à jour.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('super_admin.plans.index')->with('success', 'Plan supprimé.');
    }
}

