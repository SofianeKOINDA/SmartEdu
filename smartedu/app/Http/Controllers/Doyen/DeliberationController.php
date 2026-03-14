<?php

namespace App\Http\Controllers\Doyen;

use App\Http\Controllers\Controller;
use App\Models\Deliberation;
use App\Models\Etudiant;
use App\Models\Promotion;
use App\Models\Semestre;
use App\Services\DeliberationService;
use Illuminate\Http\Request;

class DeliberationController extends Controller
{
    public function __construct(private DeliberationService $service) {}

    public function index()
    {
        $this->authorize('viewAny', Deliberation::class);

        $semestres = Semestre::orderByDesc('created_at')->get();
        $promotions = Promotion::orderBy('nom')->get();

        $deliberations = Deliberation::with(['etudiant.user', 'semestre'])
            ->orderByDesc('delibere_le')
            ->paginate(20);

        return view('doyen.deliberations.index', compact('deliberations', 'semestres', 'promotions'));
    }

    public function lancer(Request $request)
    {
        $this->authorize('create', Deliberation::class);

        $data = $request->validate([
            'semestre_id' => ['required', 'exists:semestres,id'],
            'promotion_id' => ['required', 'exists:promotions,id'],
        ]);

        $semestre = Semestre::findOrFail($data['semestre_id']);
        $etudiants = Etudiant::where('promotion_id', $data['promotion_id'])->get();

        foreach ($etudiants as $e) {
            $this->service->deliberer($e, $semestre);
        }

        return redirect()->route('doyen.deliberations.index')->with('success', 'Délibération lancée.');
    }
}

