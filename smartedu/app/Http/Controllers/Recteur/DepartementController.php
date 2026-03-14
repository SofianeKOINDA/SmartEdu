<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Faculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartementController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Departement::class);

        $departements = Departement::with('faculte')->orderByDesc('created_at')->paginate(20);
        return view('recteur.departements.index', compact('departements'));
    }

    public function create()
    {
        $this->authorize('create', Departement::class);

        $facultes = Faculte::orderBy('nom')->get();
        return view('recteur.departements.create', compact('facultes'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Departement::class);

        $data = $request->validate([
            'faculte_id' => ['required', 'exists:facultes,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
        ]);

        Departement::create(['tenant_id' => Auth::user()->tenant_id, ...$data]);

        return redirect()->route('recteur.departements.index')->with('success', 'Département créé.');
    }

    public function show(Departement $departement)
    {
        return redirect()->route('recteur.departements.edit', $departement);
    }

    public function edit(Departement $departement)
    {
        $this->authorize('update', $departement);
        $facultes = Faculte::orderBy('nom')->get();

        return view('doyen.departements.edit', compact('departement', 'facultes'));
    }

    public function update(Request $request, Departement $departement)
    {
        $this->authorize('update', $departement);

        $data = $request->validate([
            'faculte_id' => ['required', 'exists:facultes,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
        ]);

        $departement->update($data);
        return redirect()->route('recteur.departements.index')->with('success', 'Département mis à jour.');
    }

    public function destroy(Departement $departement)
    {
        $this->authorize('delete', $departement);
        $departement->delete();
        return redirect()->route('recteur.departements.index')->with('success', 'Département supprimé.');
    }
}

