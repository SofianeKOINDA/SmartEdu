<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeanceRequest;
use App\Http\Requests\UpdateSeanceRequest;
use App\Models\Cours;
use App\Models\Promotion;
use App\Models\Seance;
use App\Services\EmploiDuTempsService;

class SeanceController extends Controller
{
    public function __construct(private EmploiDuTempsService $emploiDuTempsService) {}

    public function index()
    {
        $this->authorize('viewAny', Seance::class);

        $seances    = Seance::with(['cours.enseignant.user', 'promotion'])->paginate(30);
        $cours      = Cours::with('enseignant.user')->get();
        $promotions = Promotion::all();

        return view('chef_departement.seances.liste', compact('seances', 'cours', 'promotions'));
    }

    public function create()
    {
        return redirect()->route('chef_departement.seances.index');
    }

    public function store(StoreSeanceRequest $request)
    {
        $this->authorize('create', Seance::class);

        $data = array_merge($request->validated(), [
            'tenant_id'     => auth()->user()->tenant_id,
            'enseignant_id' => Cours::find($request->cours_id)?->enseignant_id,
        ]);

        $this->emploiDuTempsService->creerSeance($data);

        return redirect()->route('chef_departement.seances.index')
            ->with('success', 'Séance créée.');
    }

    public function show(Seance $seance)
    {
        return redirect()->route('chef_departement.seances.index');
    }

    public function edit(Seance $seance)
    {
        return redirect()->route('chef_departement.seances.index');
    }

    public function update(UpdateSeanceRequest $request, Seance $seance)
    {
        $this->authorize('update', $seance);

        $data = array_merge($request->validated(), [
            'id'            => $seance->id,
            'tenant_id'     => $seance->tenant_id,
            'enseignant_id' => $seance->cours->enseignant_id,
        ]);

        $this->emploiDuTempsService->verifierConflits($data);
        $seance->update($request->validated());

        return redirect()->route('chef_departement.seances.index')
            ->with('success', 'Séance mise à jour.');
    }

    public function destroy(Seance $seance)
    {
        $this->authorize('delete', $seance);

        $seance->delete();

        return redirect()->route('chef_departement.seances.index')
            ->with('success', 'Séance supprimée.');
    }
}
