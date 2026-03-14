<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Promotion;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Etudiant::class);

        $promotionId = $request->query('promotion_id');
        $promotions = Promotion::orderBy('nom')->get();

        $etudiants = Etudiant::with(['user', 'promotion.filiere.departement.faculte'])
            ->when($promotionId, fn ($q) => $q->where('promotion_id', $promotionId))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('doyen.etudiants.index', compact('etudiants', 'promotions', 'promotionId'));
    }

    public function show(Etudiant $etudiant)
    {
        $this->authorize('view', $etudiant);

        $etudiant->load(['user', 'promotion.filiere.departement.faculte', 'deliberations.semestre']);
        return view('doyen.etudiants.show', compact('etudiant'));
    }
}

