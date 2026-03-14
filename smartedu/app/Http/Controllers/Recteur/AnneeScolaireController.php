<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnneeScolaireController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', AnneeScolaire::class);

        $annees = AnneeScolaire::orderByDesc('date_debut')->paginate(20);
        return view('recteur.annees_scolaires.index', compact('annees'));
    }

    public function create()
    {
        $this->authorize('create', AnneeScolaire::class);
        return view('recteur.annees_scolaires.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', AnneeScolaire::class);

        $data = $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'courante' => ['nullable', 'boolean'],
        ]);

        if (!empty($data['courante'])) {
            AnneeScolaire::where('tenant_id', Auth::user()->tenant_id)->update(['courante' => false]);
        }

        AnneeScolaire::create([
            'tenant_id' => Auth::user()->tenant_id,
            'libelle' => $data['libelle'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'courante' => (bool) ($data['courante'] ?? false),
        ]);

        return redirect()->route('recteur.annees-scolaires.index')->with('success', 'Année scolaire créée.');
    }

    public function show(AnneeScolaire $annees_scolaire)
    {
        return redirect()->route('recteur.annees-scolaires.edit', $annees_scolaire);
    }

    public function edit(AnneeScolaire $annees_scolaire)
    {
        $this->authorize('update', $annees_scolaire);
        return view('recteur.annees_scolaires.edit', ['annee' => $annees_scolaire]);
    }

    public function update(Request $request, AnneeScolaire $annees_scolaire)
    {
        $this->authorize('update', $annees_scolaire);

        $data = $request->validate([
            'libelle' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'courante' => ['nullable', 'boolean'],
        ]);

        if (!empty($data['courante'])) {
            AnneeScolaire::where('tenant_id', Auth::user()->tenant_id)
                ->where('id', '!=', $annees_scolaire->id)
                ->update(['courante' => false]);
        }

        $annees_scolaire->update([
            'libelle' => $data['libelle'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'courante' => (bool) ($data['courante'] ?? false),
        ]);

        return redirect()->route('recteur.annees-scolaires.index')->with('success', 'Année scolaire mise à jour.');
    }

    public function destroy(AnneeScolaire $annees_scolaire)
    {
        $this->authorize('delete', $annees_scolaire);
        $annees_scolaire->delete();
        return redirect()->route('recteur.annees-scolaires.index')->with('success', 'Année scolaire supprimée.');
    }
}

