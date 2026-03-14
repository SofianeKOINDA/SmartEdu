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

        $tarifs          = Tarif::with('anneeScolaire')->paginate(20);
        $anneesScolaires = AnneeScolaire::all();

        return view('recteur.tarifs.liste', compact('tarifs', 'anneesScolaires'));
    }

    public function create()
    {
        return redirect()->route('recteur.tarifs.index');
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
        return redirect()->route('recteur.tarifs.index');
    }

    public function edit(Tarif $tarif)
    {
        return redirect()->route('recteur.tarifs.index');
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
