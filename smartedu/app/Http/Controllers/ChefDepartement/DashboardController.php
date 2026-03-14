<?php

namespace App\Http\Controllers\ChefDepartement;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Promotion;
use App\Models\Seance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tenantId = Auth::user()->tenant_id;

        $nbPromotions = Promotion::where('tenant_id', $tenantId)->count();
        $nbSeances    = Seance::where('tenant_id', $tenantId)->count();
        $nbCours      = Cours::where('tenant_id', $tenantId)->count();
        $nbEtudiants  = Etudiant::where('tenant_id', $tenantId)->count();

        $seances = Seance::with(['cours', 'promotion'])
            ->where('tenant_id', $tenantId)
            ->get();

        $joursOrdre = ['lundi' => 1,'mardi' => 2,'mercredi' => 3,'jeudi' => 4,'vendredi' => 5,'samedi' => 6];
        $jourActuel = strtolower(now()->locale('fr')->dayName);

        $prochainesSeances = $seances
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
            ->sortBy(function (Seance $s) use ($joursOrdre) {
                $dateScore = Carbon::parse($s->next_date)->timestamp;
                $timeScore = intval(str_replace(':', '', substr((string) $s->heure_debut, 0, 5)));
                $jourScore = $joursOrdre[$s->jour] ?? 7;
                return $dateScore . sprintf('%02d', $jourScore) . sprintf('%04d', $timeScore);
            })
            ->values()
            ->take(5);

        return view('chef_departement', compact(
            'nbPromotions',
            'nbSeances',
            'nbCours',
            'nbEtudiants',
            'prochainesSeances'
        ));
    }
}
