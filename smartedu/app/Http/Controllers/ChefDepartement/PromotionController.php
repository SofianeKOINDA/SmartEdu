<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\AnneeScolaire;
use App\Models\Filiere;
use App\Models\Promotion;

class PromotionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Promotion::class);

        $promotions = Promotion::with(['filiere', 'anneeScolaire'])->paginate(20);

        return view('chef_departement.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $this->authorize('create', Promotion::class);

        $filieres = Filiere::all();
        $anneesScolaires = AnneeScolaire::all();

        return view('chef_departement.promotions.create', compact('filieres', 'anneesScolaires'));
    }

    public function store(StorePromotionRequest $request)
    {
        $this->authorize('create', Promotion::class);

        Promotion::create($request->validated());

        return redirect()->route('chef_departement.promotions.index')
            ->with('success', 'Promotion créée.');
    }

    public function show(Promotion $promotion)
    {
        $this->authorize('view', $promotion);

        return view('chef_departement.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $this->authorize('update', $promotion);

        $filieres = Filiere::all();
        $anneesScolaires = AnneeScolaire::all();

        return view('chef_departement.promotions.edit', compact('promotion', 'filieres', 'anneesScolaires'));
    }

    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $this->authorize('update', $promotion);

        $promotion->update($request->validated());

        return redirect()->route('chef_departement.promotions.index')
            ->with('success', 'Promotion mise à jour.');
    }

    public function destroy(Promotion $promotion)
    {
        $this->authorize('delete', $promotion);

        $promotion->delete();

        return redirect()->route('chef_departement.promotions.index')
            ->with('success', 'Promotion supprimée.');
    }
}
