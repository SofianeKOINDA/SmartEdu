<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Deliberation;

class ResultatController extends Controller
{
    public function index()
    {
        $etudiant = $this->getEtudiant();

        $deliberations = Deliberation::with('semestre')
            ->where('etudiant_id', $etudiant->id)
            ->orderByDesc('delibere_le')
            ->get();

        return view('etudiant.resultats.liste', compact('deliberations'));
    }
}
