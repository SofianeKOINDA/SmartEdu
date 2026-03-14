<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FiliereController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Filiere::class);

        $filieres = Filiere::with(['departement'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('chef_departement.filieres.index', compact('filieres'));
    }

    public function create()
    {
        $this->authorize('create', Filiere::class);

        $departements = Departement::orderBy('nom')->get();
        return view('chef_departement.filieres.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Filiere::class);

        $data = $request->validate([
            'departement_id' => ['required', 'exists:departements,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'duree_annees' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        Filiere::create([
            'tenant_id' => Auth::user()->tenant_id,
            ...$data,
        ]);

        return redirect()->route('chef_departement.filieres.index')->with('success', 'Filière créée.');
    }

    public function edit(Filiere $filiere)
    {
        $this->authorize('update', $filiere);

        $departements = Departement::orderBy('nom')->get();
        return view('chef_departement.filieres.edit', compact('filiere', 'departements'));
    }

    public function show(Filiere $filiere)
    {
        return redirect()->route('chef_departement.filieres.edit', $filiere);
    }

    public function update(Request $request, Filiere $filiere)
    {
        $this->authorize('update', $filiere);

        $data = $request->validate([
            'departement_id' => ['required', 'exists:departements,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'duree_annees' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $filiere->update($data);

        return redirect()->route('chef_departement.filieres.index')->with('success', 'Filière mise à jour.');
    }

    public function destroy(Filiere $filiere)
    {
        $this->authorize('delete', $filiere);

        $filiere->delete();

        return redirect()->route('chef_departement.filieres.index')->with('success', 'Filière supprimée.');
    }
}

