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

        $promotions      = Promotion::with(['filiere', 'anneeScolaire'])->paginate(20);
        $filieres        = Filiere::all();
        $anneesScolaires = AnneeScolaire::all();

        return view('chef_departement.promotions.liste', compact('promotions', 'filieres', 'anneesScolaires'));
    }

    public function create()
    {
        return redirect()->route('chef_departement.promotions.index');
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
        return redirect()->route('chef_departement.promotions.index');
    }

    public function edit(Promotion $promotion)
    {
        return redirect()->route('chef_departement.promotions.index');
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
