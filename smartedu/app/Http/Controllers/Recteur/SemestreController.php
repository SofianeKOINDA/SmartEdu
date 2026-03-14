<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemestreController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Semestre::class);

        $semestres = Semestre::with('anneeScolaire')->orderByDesc('created_at')->paginate(20);
        return view('recteur.semestres.index', compact('semestres'));
    }

    public function create()
    {
        $this->authorize('create', Semestre::class);

        $annees = AnneeScolaire::orderByDesc('date_debut')->get();
        return view('recteur.semestres.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Semestre::class);

        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'nom' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'integer', 'min:1', 'max:12'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'actif' => ['nullable', 'boolean'],
        ]);

        Semestre::create(['tenant_id' => Auth::user()->tenant_id, ...$data]);

        return redirect()->route('recteur.semestres.index')->with('success', 'Semestre créé.');
    }

    public function show(Semestre $semestre)
    {
        return redirect()->route('recteur.semestres.edit', $semestre);
    }

    public function edit(Semestre $semestre)
    {
        $this->authorize('update', $semestre);

        $annees = AnneeScolaire::orderByDesc('date_debut')->get();
        return view('recteur.semestres.edit', compact('semestre', 'annees'));
    }

    public function update(Request $request, Semestre $semestre)
    {
        $this->authorize('update', $semestre);

        $data = $request->validate([
            'annee_scolaire_id' => ['required', 'exists:annees_scolaires,id'],
            'nom' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'integer', 'min:1', 'max:12'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $semestre->update($data);
        return redirect()->route('recteur.semestres.index')->with('success', 'Semestre mis à jour.');
    }

    public function destroy(Semestre $semestre)
    {
        $this->authorize('delete', $semestre);
        $semestre->delete();
        return redirect()->route('recteur.semestres.index')->with('success', 'Semestre supprimé.');
    }
}

