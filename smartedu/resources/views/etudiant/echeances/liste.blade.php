@include("sections.etudiant.head")
<body>
<div class="main-wrapper">
    @include("sections.etudiant.menuHaut")
    @include("sections.etudiant.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mes paiements</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Mes paiements</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Résumé --}}
            @php
                $total     = $echeances->sum('montant');
                $paye      = $echeances->where('statut','paye')->sum('montant');
                $restant   = $total - $paye;
                $enRetard  = $echeances->where('statut','retard')->count();
            @endphp
            <div class="row mb-3">
                <div class="col-md-3 col-6">
                    <div class="card comman-shadow text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Total annuel</h6>
                            <h4 class="text-primary">{{ number_format($total, 0, ',', ' ') }} FCFA</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card comman-shadow text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Payé</h6>
                            <h4 class="text-success">{{ number_format($paye, 0, ',', ' ') }} FCFA</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card comman-shadow text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Restant</h6>
                            <h4 class="text-warning">{{ number_format($restant, 0, ',', ' ') }} FCFA</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card comman-shadow text-center">
                        <div class="card-body">
                            <h6 class="text-muted">En retard</h6>
                            <h4 class="{{ $enRetard > 0 ? 'text-danger' : 'text-muted' }}">{{ $enRetard }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Année scolaire</th>
                                            <th>Montant</th>
                                            <th>Date limite</th>
                                            <th>Statut</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($echeances as $echeance)
                                        <tr class="{{ $echeance->statut === 'retard' ? 'table-danger' : '' }}">
                                            <td><strong>Mois {{ $echeance->numero_mois }}</strong></td>
                                            <td>{{ $echeance->tarif->anneeScolaire->libelle ?? '—' }}</td>
                                            <td class="fw-bold">{{ number_format($echeance->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ \Carbon\Carbon::parse($echeance->date_limite)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($echeance->statut === 'paye')
                                                    <span class="badge bg-success">Payé</span>
                                                @elseif($echeance->statut === 'retard')
                                                    <span class="badge bg-danger">En retard</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($echeance->statut !== 'paye')
                                                <button class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#payerModal{{ $echeance->id }}">
                                                    <i class="fas fa-credit-card me-1"></i> Payer
                                                </button>
                                                @else
                                                <span class="text-success"><i class="fas fa-check-circle"></i> Payé</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="6" class="text-center text-muted">Aucune échéance générée pour le moment.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modals Payer --}}
@foreach($echeances->where('statut', '!=', 'paye') as $echeance)
<div class="modal fade" id="payerModal{{ $echeance->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer le paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
                <p>Payer <strong>Mois {{ $echeance->numero_mois }}</strong></p>
                <p class="fs-5 fw-bold text-primary">{{ number_format($echeance->montant, 0, ',', ' ') }} FCFA</p>
                <p class="text-muted small">Vous serez redirigé vers la page de paiement sécurisé PayTech (Orange Money, Wave, CB…)</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('etudiant.echeances.payer', $echeance) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Payer maintenant</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
