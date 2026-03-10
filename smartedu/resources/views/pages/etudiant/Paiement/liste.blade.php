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
                        <h3 class="page-title">Mes Paiements</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Paiements</li>
                        </ul>
                    </div>
                </div>
            </div>

            @php
                $totalPaye      = $paiements->where('statut', 'valide')->sum('montant');
                $totalEnAttente = $paiements->where('statut', 'en_attente')->sum('montant');
                $methodeLabels  = ['especes'=>'Espèces','virement'=>'Virement','carte'=>'Carte','mobile_money'=>'Mobile Money'];
                $typeLabels     = ['scolarite'=>'Scolarité','inscription'=>'Inscription'];
            @endphp

            <div class="row mb-4">
                <div class="col-md-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Total payé</h6>
                                    <h3>{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>En attente</h6>
                                    <h3>{{ number_format($totalEnAttente, 0, ',', ' ') }} FCFA</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Nb paiements</h6>
                                    <h3>{{ $paiements->count() }}</h3>
                                </div>
                                <div class="db-icon">
                                    <i class="fas fa-file-invoice-dollar fa-2x text-primary"></i>
                                </div>
                            </div>
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
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Montant</th>
                                            <th>Méthode</th>
                                            <th class="text-center">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paiements as $paiement)
                                        <tr>
                                            <td>{{ $paiement->date ? \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') : '—' }}</td>
                                            <td>{{ $typeLabels[$paiement->type] ?? ($paiement->type ?? '—') }}</td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $methodeLabels[$paiement->methode] ?? ($paiement->methode ?? '—') }}</td>
                                            <td class="text-center">
                                                @if($paiement->statut === 'valide')
                                                    <span class="badge bg-success">Validé</span>
                                                @elseif($paiement->statut === 'en_attente')
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @elseif($paiement->statut === 'refuse')
                                                    <span class="badge bg-danger">Refusé</span>
                                                @elseif($paiement->statut === 'rembourse')
                                                    <span class="badge bg-info text-dark">Remboursé</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $paiement->statut }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucun paiement enregistré.</td>
                                        </tr>
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

<!-- Modal Profil -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier mon profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('etudiant.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="{{ auth()->user()->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="{{ auth()->user()->prenom }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo de profil</label>
                        <input type="file" name="photo_profil" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include("sections.etudiant.script")
</body>
</html>
