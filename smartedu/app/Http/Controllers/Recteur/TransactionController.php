<?php

namespace App\Http\Controllers\Recteur;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Transaction::class);

        $transactions = Transaction::with(['etudiant.user', 'echeance.tarif.anneeScolaire'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return view('recteur.transactions.index', compact('transactions'));
    }
}

