<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\Faculte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaculteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Faculte::class);

        $facultes = Faculte::orderByDesc('created_at')->paginate(20);
        return view('recteur.facultes.index', compact('facultes'));
    }

    public function create()
    {
        $this->authorize('create', Faculte::class);
        return view('recteur.facultes.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Faculte::class);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Faculte::create([
            'tenant_id' => Auth::user()->tenant_id,
            ...$data,
        ]);

        return redirect()->route('recteur.facultes.index')->with('success', 'Faculté créée.');
    }

    public function show(Faculte $faculte)
    {
        return redirect()->route('recteur.facultes.edit', $faculte);
    }

    public function edit(Faculte $faculte)
    {
        $this->authorize('update', $faculte);
        return view('recteur.facultes.edit', compact('faculte'));
    }

    public function update(Request $request, Faculte $faculte)
    {
        $this->authorize('update', $faculte);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $faculte->update($data);

        return redirect()->route('recteur.facultes.index')->with('success', 'Faculté mise à jour.');
    }

    public function destroy(Faculte $faculte)
    {
        $this->authorize('delete', $faculte);
        $faculte->delete();

        return redirect()->route('recteur.facultes.index')->with('success', 'Faculté supprimée.');
    }
}

