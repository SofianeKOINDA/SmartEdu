<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;

class EnseignantController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Enseignant::class);

        $enseignants = Enseignant::with(['user', 'departement.faculte'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('doyen.enseignants.index', compact('enseignants'));
    }

    public function show(Enseignant $enseignant)
    {
        $this->authorize('view', $enseignant);

        $enseignant->load(['user', 'departement.faculte', 'cours.ue']);
        return view('doyen.enseignants.show', compact('enseignant'));
    }
}

