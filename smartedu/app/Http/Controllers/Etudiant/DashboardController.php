<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Echeance;
use App\Models\Presence;
use App\Models\Seance;

class DashboardController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        // Nb cours
        $nbCours = $etudiant->cours()->count();

        // Moyenne générale (valeur pondérée par coefficient)
        $notes = $etudiant->notes()->with('evaluation')->get();
        $moyenneGenerale = null;
        if ($notes->isNotEmpty()) {
            $sumPonderee = $notes->sum(fn($n) => $n->valeur * ($n->evaluation->coefficient ?? 1));
            $sumCoeff    = $notes->sum(fn($n) => $n->evaluation->coefficient ?? 1);
            $moyenneGenerale = $sumCoeff > 0 ? round($sumPonderee / $sumCoeff, 2) : null;
        }

        // Prochaine échéance non payée
        $prochaineEcheance = Echeance::where('etudiant_id', $etudiant->id)
            ->whereIn('statut', ['en_attente', 'retard'])
            ->orderBy('date_limite')
            ->first();

        // Prochaine séance (basée sur la promotion)
        $joursOrdre = ['lundi' => 1,'mardi' => 2,'mercredi' => 3,'jeudi' => 4,'vendredi' => 5,'samedi' => 6];
        $jourActuel = strtolower(now()->locale('fr')->dayName);
        $prochaineSeance = Seance::with(['cours.enseignant.user'])
            ->where('promotion_id', $etudiant->promotion_id)
            ->where('recurrent', true)
            ->get()
            ->sortBy(fn($s) => (($joursOrdre[$s->jour] ?? 7) - ($joursOrdre[$jourActuel] ?? 1) + 7) % 7 * 1440
                + intval(str_replace(':', '', substr($s->heure_debut, 0, 5))))
            ->first();

        // Taux de présence
        $totalPresences = $etudiant->presences()->count();
        $totalPresents  = $etudiant->presences()->where('statut', 'present')->count();
        $tauxPresence   = $totalPresences > 0 ? round($totalPresents / $totalPresences * 100) : null;

        // Dernières notes
        $dernieresNotes = $etudiant->notes()
            ->with(['evaluation.cours'])
            ->latest()
            ->take(5)
            ->get();

        return view('etudiant', compact(
            'nbCours',
            'moyenneGenerale',
            'prochaineEcheance',
            'prochaineSeance',
            'tauxPresence',
            'dernieresNotes'
        ));
    }
}
