<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTarifRequest;
use App\Http\Requests\UpdateTarifRequest;
use App\Models\AnneeScolaire;
use App\Models\Tarif;

class TarifController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tarif::class);

        $tarifs = Tarif::with('anneeScolaire')->paginate(20);

        return view('recteur.tarifs.index', compact('tarifs'));
    }

    public function create()
    {
        $this->authorize('create', Tarif::class);

        $anneesScolaires = AnneeScolaire::all();

        return view('recteur.tarifs.create', compact('anneesScolaires'));
    }

    public function store(StoreTarifRequest $request)
    {
        $this->authorize('create', Tarif::class);

        $data = $request->validated();
        $data['cree_par'] = auth()->id();

        Tarif::create($data);

        return redirect()->route('recteur.tarifs.index')
            ->with('success', 'Tarif créé. Les échéances ont été générées automatiquement.');
    }

    public function show(Tarif $tarif)
    {
        $this->authorize('view', $tarif);

        return view('recteur.tarifs.show', compact('tarif'));
    }

    public function edit(Tarif $tarif)
    {
        $this->authorize('update', $tarif);

        return view('recteur.tarifs.edit', compact('tarif'));
    }

    public function update(UpdateTarifRequest $request, Tarif $tarif)
    {
        $this->authorize('update', $tarif);

        $tarif->update($request->validated());

        return redirect()->route('recteur.tarifs.index')
            ->with('success', 'Tarif mis à jour.');
    }

    public function destroy(Tarif $tarif)
    {
        $this->authorize('delete', $tarif);

        $tarif->delete();

        return redirect()->route('recteur.tarifs.index')
            ->with('success', 'Tarif supprimé.');
    }
}
