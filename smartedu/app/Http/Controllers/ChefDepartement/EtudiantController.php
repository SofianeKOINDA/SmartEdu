<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Etudiant::class);

        $promotionId = $request->query('promotion_id');

        $promotions = Promotion::orderBy('nom')->get();

        $etudiants = Etudiant::with(['user', 'promotion'])
            ->when($promotionId, fn ($q) => $q->where('promotion_id', $promotionId))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('chef_departement.etudiants.index', compact('etudiants', 'promotions', 'promotionId'));
    }

    public function create()
    {
        $this->authorize('create', Etudiant::class);

        $promotions = Promotion::orderBy('nom')->get();
        return view('chef_departement.etudiants.create', compact('promotions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Etudiant::class);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'promotion_id' => ['required', 'exists:promotions,id'],
            'numero_etudiant' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'tenant_id' => Auth::user()->tenant_id,
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'etudiant',
        ]);

        Etudiant::create([
            'tenant_id' => Auth::user()->tenant_id,
            'user_id' => $user->id,
            'promotion_id' => $data['promotion_id'],
            'numero_etudiant' => $data['numero_etudiant'] ?? null,
            'actif' => true,
        ]);

        return redirect()->route('chef_departement.etudiants.index')->with('success', 'Étudiant créé.');
    }

    public function show(Etudiant $etudiant)
    {
        $this->authorize('view', $etudiant);

        $etudiant->load(['user', 'promotion', 'echeances', 'transactions', 'notes.evaluation.cours', 'presences.cours']);

        return view('chef_departement.etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $this->authorize('update', $etudiant);

        $promotions = Promotion::orderBy('nom')->get();
        $etudiant->load(['user', 'promotion']);

        return view('chef_departement.etudiants.edit', compact('etudiant', 'promotions'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $this->authorize('update', $etudiant);

        $data = $request->validate([
            'promotion_id' => ['required', 'exists:promotions,id'],
            'numero_etudiant' => ['nullable', 'string', 'max:255'],
            'actif' => ['required', 'boolean'],
        ]);

        $etudiant->update($data);

        return redirect()->route('chef_departement.etudiants.index')->with('success', 'Étudiant mis à jour.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $this->authorize('delete', $etudiant);

        $etudiant->delete();

        return redirect()->route('chef_departement.etudiants.index')->with('success', 'Étudiant supprimé.');
    }
}

