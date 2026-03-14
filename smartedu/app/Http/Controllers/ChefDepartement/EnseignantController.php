<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EnseignantController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Enseignant::class);

        $enseignants = Enseignant::with(['user', 'departement'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('chef_departement.enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $this->authorize('create', Enseignant::class);

        $departements = Departement::orderBy('nom')->get();
        return view('chef_departement.enseignants.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Enseignant::class);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'grade' => ['nullable', 'string', 'max:255'],
            'specialite' => ['nullable', 'string', 'max:255'],
            'matricule' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'tenant_id' => Auth::user()->tenant_id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'enseignant',
        ]);

        Enseignant::create([
            'tenant_id' => Auth::user()->tenant_id,
            'user_id' => $user->id,
            'departement_id' => $data['departement_id'] ?? null,
            'grade' => $data['grade'] ?? null,
            'specialite' => $data['specialite'] ?? null,
            'matricule' => $data['matricule'] ?? null,
        ]);

        return redirect()->route('chef_departement.enseignants.index')->with('success', 'Enseignant créé.');
    }

    public function show(Enseignant $enseignant)
    {
        $this->authorize('view', $enseignant);

        $enseignant->load(['user', 'departement', 'cours.ue']);
        return view('chef_departement.enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        $this->authorize('update', $enseignant);

        $departements = Departement::orderBy('nom')->get();
        $enseignant->load(['user', 'departement']);

        return view('chef_departement.enseignants.edit', compact('enseignant', 'departements'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $this->authorize('update', $enseignant);

        $data = $request->validate([
            'departement_id' => ['nullable', 'exists:departements,id'],
            'grade' => ['nullable', 'string', 'max:255'],
            'specialite' => ['nullable', 'string', 'max:255'],
            'matricule' => ['nullable', 'string', 'max:255'],
        ]);

        $enseignant->update($data);

        return redirect()->route('chef_departement.enseignants.index')->with('success', 'Enseignant mis à jour.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $this->authorize('delete', $enseignant);

        $enseignant->delete();

        return redirect()->route('chef_departement.enseignants.index')->with('success', 'Enseignant supprimé.');
    }
}

