<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Etudiant;
use App\Http\Requests\StorePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    /**
     * Liste des paiements — admin voit tout, étudiant voit les siens.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'etudiant') {
            $paiements = $user->etudiant->paiements()
                ->orderBy('date', 'desc')
                ->paginate(15);
            $etudiants = collect();
        } else {
            $paiements = Paiement::with('etudiant.user')
                ->orderBy('date', 'desc')
                ->paginate(15);
            $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        }

        return view('pages.admin.paiements', compact('paiements', 'etudiants'));
    }

    /**
     * Enregistrer un paiement via modal (admin).
     */
    public function store(StorePaiementRequest $request)
    {
        Paiement::create($request->validated());
        return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Modifier un paiement via modal (admin).
     */
    public function update(UpdatePaiementRequest $request, Paiement $paiement)
    {
        $paiement->update($request->validated());
        return redirect()->back()->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Supprimer un paiement via modal (admin).
     */
    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->back()->with('success', 'Paiement supprimé avec succès.');
    }
}
