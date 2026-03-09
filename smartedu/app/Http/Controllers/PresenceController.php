<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Support\Facades\Auth;
use App\Models\Cours;
use App\Models\Etudiant;
use App\Http\Requests\StorePresenceRequest;
use App\Http\Requests\UpdatePresenceRequest;

class PresenceController extends Controller
{
    /**
     * Liste des présences — enseignant voit ses cours, étudiant voit les siennes.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'enseignant') {
            $coursIds = $user->enseignant->cours()->pluck('id');
            $presences = Presence::whereIn('cours_id', $coursIds)
                ->with(['etudiant.user', 'cours'])
                ->orderBy('date', 'desc')
                ->paginate(20);
            $cours = Cours::whereIn('id', $coursIds)->orderBy('titre')->get();
            $etudiants = Etudiant::whereIn('classe_id',
                    $cours->flatMap->classes->pluck('id')->unique()
                )->with('user')->orderBy('matricule')->get();
        } elseif ($user->role === 'etudiant') {
            $presences = $user->etudiant->presences()
                ->with('cours')
                ->orderBy('date', 'desc')
                ->paginate(20);
            $cours     = collect();
            $etudiants = collect();
        } else {
            $presences = Presence::with(['etudiant.user', 'cours'])
                ->orderBy('date', 'desc')
                ->paginate(20);
            $cours     = Cours::orderBy('titre')->get();
            $etudiants = Etudiant::with('user')->orderBy('matricule')->get();
        }

        return view('pages.enseignant.presences', compact('presences', 'cours', 'etudiants'));
    }

    /**
     * Enregistrer une présence via modal.
     */
    public function store(StorePresenceRequest $request)
    {
        Presence::create($request->validated());
        return redirect()->back()->with('success', 'Présence enregistrée avec succès.');
    }

    /**
     * Modifier une présence via modal.
     */
    public function update(UpdatePresenceRequest $request, Presence $presence)
    {
        $presence->update($request->validated());
        return redirect()->back()->with('success', 'Présence mise à jour avec succès.');
    }

    /**
     * Supprimer une présence via modal.
     */
    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->back()->with('success', 'Présence supprimée avec succès.');
    }
}
