<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Evaluation;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Evaluation $evaluation)
    {
        $this->authorize('viewAny', Note::class);

        $evaluation->load(['cours.etudiants.user']);

        $notes = Note::with('etudiant.user')
            ->where('evaluation_id', $evaluation->id)
            ->get()
            ->keyBy('etudiant_id');

        $etudiants = $evaluation->cours->etudiants()->with('user')->get();

        return view('enseignant.notes.liste', compact('evaluation', 'notes', 'etudiants'));
    }

    public function create(Evaluation $evaluation)
    {
        return redirect()->route('enseignant.notes.index', $evaluation);
    }

    public function store(StoreNoteRequest $request)
    {
        $this->authorize('create', Note::class);

        $data = array_merge($request->validated(), ['saisi_par' => Auth::id()]);

        Note::create($data);

        return redirect()->route('enseignant.notes.index', $request->evaluation_id)
            ->with('success', 'Note enregistrée.');
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $note->update($request->validated());

        return redirect()->route('enseignant.notes.index', $note->evaluation_id)
            ->with('success', 'Note mise à jour.');
    }

    public function import(Request $request, Evaluation $evaluation)
    {
        $this->authorize('create', Note::class);

        $request->validate([
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $evaluation->load(['cours.etudiants.user']);

        $handle = fopen($request->file('csv')->getRealPath(), 'r');
        if ($handle === false) {
            return back()->with('error', 'Impossible de lire le fichier.');
        }

        $header = fgetcsv($handle);
        $header = is_array($header) ? array_map(fn ($h) => strtolower(trim((string) $h)), $header) : [];

        $byEtudiantId = array_search('etudiant_id', $header, true);
        $byEmail      = array_search('email', $header, true);
        $byValeur     = array_search('valeur', $header, true);

        if ($byValeur === false || ($byEtudiantId === false && $byEmail === false)) {
            fclose($handle);
            return back()->with('error', "CSV invalide. Colonnes attendues: 'valeur' + ('etudiant_id' ou 'email').");
        }

        $etudiantsDuCours = $evaluation->cours->etudiants->keyBy('id');
        $emailToEtudiantId = $evaluation->cours->etudiants
            ->filter(fn ($e) => $e->user && $e->user->email)
            ->mapWithKeys(fn ($e) => [strtolower($e->user->email) => $e->id]);

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $valeur = $row[$byValeur] ?? null;
            if ($valeur === null || $valeur === '') {
                continue;
            }

            $etudiantId = null;
            if ($byEtudiantId !== false) {
                $etudiantId = isset($row[$byEtudiantId]) ? (int) $row[$byEtudiantId] : null;
            } elseif ($byEmail !== false) {
                $email = strtolower(trim((string) ($row[$byEmail] ?? '')));
                $etudiantId = $emailToEtudiantId[$email] ?? null;
            }

            if (! $etudiantId || ! $etudiantsDuCours->has($etudiantId)) {
                continue;
            }

            Note::updateOrCreate(
                [
                    'evaluation_id' => $evaluation->id,
                    'etudiant_id'   => $etudiantId,
                ],
                [
                    'tenant_id' => Auth::user()->tenant_id,
                    'saisi_par' => Auth::id(),
                    'valeur'    => (float) $valeur,
                ]
            );

            $count++;
        }

        fclose($handle);

        return redirect()->route('enseignant.notes.index', $evaluation)
            ->with('success', $count . ' note(s) importée(s).');
    }
}
