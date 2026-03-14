<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\UE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cours::class);

        $cours = Cours::with(['ue', 'enseignant.user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('chef_departement.cours.index', compact('cours'));
    }

    public function create()
    {
        $this->authorize('create', Cours::class);

        $ues = UE::orderBy('nom')->get();
        $enseignants = Enseignant::with('user')->orderByDesc('created_at')->get();

        return view('chef_departement.cours.create', compact('ues', 'enseignants'));
    }

    public function show(Cours $cour)
    {
        return redirect()->route('chef_departement.cours.edit', $cour);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Cours::class);

        $data = $request->validate([
            'ue_id' => ['required', 'exists:ues,id'],
            'enseignant_id' => ['nullable', 'exists:enseignants,id'],
            'intitule' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'coefficient' => ['required', 'numeric', 'min:0'],
            'volume_horaire' => ['required', 'integer', 'min:0'],
        ]);

        Cours::create([
            'tenant_id' => Auth::user()->tenant_id,
            ...$data,
        ]);

        return redirect()->route('chef_departement.cours.index')->with('success', 'Cours créé.');
    }

    public function edit(Cours $cour)
    {
        $this->authorize('update', $cour);

        $ues = UE::orderBy('nom')->get();
        $enseignants = Enseignant::with('user')->orderByDesc('created_at')->get();

        return view('chef_departement.cours.edit', ['cours' => $cour, 'ues' => $ues, 'enseignants' => $enseignants]);
    }

    public function update(Request $request, Cours $cour)
    {
        $this->authorize('update', $cour);

        $data = $request->validate([
            'ue_id' => ['required', 'exists:ues,id'],
            'enseignant_id' => ['nullable', 'exists:enseignants,id'],
            'intitule' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'coefficient' => ['required', 'numeric', 'min:0'],
            'volume_horaire' => ['required', 'integer', 'min:0'],
        ]);

        $cour->update($data);

        return redirect()->route('chef_departement.cours.index')->with('success', 'Cours mis à jour.');
    }

    public function destroy(Cours $cour)
    {
        $this->authorize('delete', $cour);

        $cour->delete();

        return redirect()->route('chef_departement.cours.index')->with('success', 'Cours supprimé.');
    }
}

