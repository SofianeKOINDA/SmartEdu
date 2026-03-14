<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Presence;

class PresenceController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $presences = Presence::with('cours')
            ->where('etudiant_id', $etudiant->id)
            ->orderByDesc('date_seance')
            ->get();

        // Calcul du taux global
        $totalPresences = $presences->count();
        $totalPresents = $presences->where('statut', 'present')->count();
        $tauxGlobal = $totalPresences > 0 ? round($totalPresents / $totalPresences * 100) : 0;

        // Groupement par cours
        $presencesParCours = $presences->groupBy(fn($p) => $p->cours->intitule ?? 'Sans cours')
            ->map(fn($groupe) => [
                'presences' => $groupe,
                'total'    => $groupe->count(),
                'presents' => $groupe->where('statut', 'present')->count(),
                'taux'     => $groupe->count() > 0
                    ? round($groupe->where('statut', 'present')->count() / $groupe->count() * 100)
                    : 0,
            ]);

        return view('etudiant.presences.liste', compact('presences', 'presencesParCours', 'tauxGlobal'));
    }
}
