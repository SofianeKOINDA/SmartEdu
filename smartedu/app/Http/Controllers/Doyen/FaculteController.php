<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaculteRequest;
use App\Http\Requests\UpdateFaculteRequest;
use App\Models\Faculte;

class FaculteController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Faculte::class);

        $facultes = Faculte::with('departements')->paginate(20);

        return view('doyen.facultes.liste', compact('facultes'));
    }

    public function create()
    {
        return redirect()->route('doyen.facultes.index');
    }

    public function store(StoreFaculteRequest $request)
    {
        $this->authorize('create', Faculte::class);

        Faculte::create($request->validated());

        return redirect()->route('doyen.facultes.index')
            ->with('success', 'Faculté créée.');
    }

    public function show(Faculte $faculte)
    {
        return redirect()->route('doyen.facultes.index');
    }

    public function edit(Faculte $faculte)
    {
        return redirect()->route('doyen.facultes.index');
    }

    public function update(UpdateFaculteRequest $request, Faculte $faculte)
    {
        $this->authorize('update', $faculte);

        $faculte->update($request->validated());

        return redirect()->route('doyen.facultes.index')
            ->with('success', 'Faculté mise à jour.');
    }

    public function destroy(Faculte $faculte)
    {
        $this->authorize('delete', $faculte);

        $faculte->delete();

        return redirect()->route('doyen.facultes.index')
            ->with('success', 'Faculté supprimée.');
    }
}
