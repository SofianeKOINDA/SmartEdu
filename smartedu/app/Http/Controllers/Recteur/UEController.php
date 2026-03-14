<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\Semestre;
use App\Models\UE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UEController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', UE::class);

        $ues = UE::with('semestre')->orderByDesc('created_at')->paginate(20);
        $semestres = Semestre::orderByDesc('created_at')->get();
        $semestreId = null;
        return view('recteur.ues.index', compact('ues', 'semestres', 'semestreId'));
    }

    public function create()
    {
        $this->authorize('create', UE::class);

        $semestres = Semestre::orderByDesc('created_at')->get();
        return view('recteur.ues.create', compact('semestres'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', UE::class);

        $data = $request->validate([
            'semestre_id' => ['required', 'exists:semestres,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'coefficient' => ['required', 'numeric', 'min:0'],
            'credit' => ['required', 'integer', 'min:0'],
        ]);

        UE::create(['tenant_id' => Auth::user()->tenant_id, ...$data]);
        return redirect()->route('recteur.ues.index')->with('success', 'UE créée.');
    }

    public function show(UE $ue)
    {
        return redirect()->route('recteur.ues.edit', $ue);
    }

    public function edit(UE $ue)
    {
        $this->authorize('update', $ue);

        $semestres = Semestre::orderByDesc('created_at')->get();
        return view('recteur.ues.edit', compact('ue', 'semestres'));
    }

    public function update(Request $request, UE $ue)
    {
        $this->authorize('update', $ue);

        $data = $request->validate([
            'semestre_id' => ['required', 'exists:semestres,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'coefficient' => ['required', 'numeric', 'min:0'],
            'credit' => ['required', 'integer', 'min:0'],
        ]);

        $ue->update($data);
        return redirect()->route('recteur.ues.index')->with('success', 'UE mise à jour.');
    }

    public function destroy(UE $ue)
    {
        $this->authorize('delete', $ue);
        $ue->delete();
        return redirect()->route('recteur.ues.index')->with('success', 'UE supprimée.');
    }
}

