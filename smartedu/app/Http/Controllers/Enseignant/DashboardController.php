<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Evaluation;
use App\Models\Presence;
use App\Models\Seance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $enseignant = $this->getEnseignant();

        $cours = Cours::with(['evaluations', 'presences'])
            ->where('enseignant_id', $enseignant?->id)
            ->get();

        $nbCours       = $cours->count();
        $nbEvaluations = $cours->sum(fn($c) => $c->evaluations->count());
        $nbEtudiants   = $cours->sum(fn($c) => $c->etudiants()->count());

        // Taux de présence moyen (sur tous les cours)
        $coursIds = $cours->pluck('id');
        $totalPresences = Presence::whereIn('cours_id', $coursIds)->count();
        $totalPresents  = Presence::whereIn('cours_id', $coursIds)->where('statut', 'present')->count();
        $tauxPresenceMoyen = $totalPresences > 0 ? round($totalPresents / $totalPresences * 100) : null;

        // Prochaines séances (calcul du prochain passage)
        $joursOrdre = ['lundi' => 1,'mardi' => 2,'mercredi' => 3,'jeudi' => 4,'vendredi' => 5,'samedi' => 6];
        $jourActuel = strtolower(now()->locale('fr')->dayName);

        $prochainesSeances = Seance::with(['cours', 'promotion'])
            ->whereIn('cours_id', $coursIds)
            ->get()
            ->map(function (Seance $s) use ($joursOrdre, $jourActuel) {
                if (! $s->recurrent && $s->date_specifique) {
                    $nextDate = Carbon::parse($s->date_specifique);
                } else {
                    $delta = (($joursOrdre[$s->jour] ?? 7) - ($joursOrdre[$jourActuel] ?? 1) + 7) % 7;
                    $nextDate = now()->startOfDay()->addDays($delta);
                }

                $s->next_date = $nextDate->toDateString();
                return $s;
            })
            ->sortBy(fn (Seance $s) => $s->next_date . ' ' . (string) $s->heure_debut)
            ->values()
            ->take(5);

        // Dernières évaluations créées
        $dernieresEvaluations = Evaluation::whereIn('cours_id', $cours->pluck('id'))
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('enseignant', compact(
            'nbCours',
            'nbEvaluations',
            'nbEtudiants',
            'tauxPresenceMoyen',
            'prochainesSeances',
            'dernieresEvaluations',
            'cours'
        ));
    }
}
