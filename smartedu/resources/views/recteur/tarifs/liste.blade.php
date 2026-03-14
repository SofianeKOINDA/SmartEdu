@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Tarifs de scolarité</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tarifs</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTarifModal">
                            <i class="fas fa-plus me-1"></i> Nouveau tarif
                        </button>
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

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Quand un tarif est créé, les échéances mensuelles sont automatiquement générées pour tous les étudiants actifs.
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Année scolaire</th>
                                            <th>Montant total</th>
                                            <th>Nb échéances</th>
                                            <th>Montant/mois</th>
                                            <th>Jour limite</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tarifs as $tarif)
                                        <tr>
                                            <td><strong>{{ $tarif->anneeScolaire->libelle ?? '—' }}</strong></td>
                                            <td>{{ number_format($tarif->montant_total, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $tarif->nombre_echeances }} mois</td>
                                            <td class="text-primary fw-bold">
                                                {{ number_format(round($tarif->montant_total / $tarif->nombre_echeances, 2), 0, ',', ' ') }} FCFA
                                            </td>
                                            <td>{{ $tarif->jour_limite }}<sup>e</sup> du mois</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTarif{{ $tarif->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteTarif{{ $tarif->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="6" class="text-center text-muted">Aucun tarif configuré.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $tarifs->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ajouter --}}
<div class="modal fade" id="addTarifModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('recteur.tarifs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Année scolaire <span class="text-danger">*</span></label>
                        <select name="annee_scolaire_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($anneesScolaires as $annee)
                            <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant total (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" name="montant_total" class="form-control" min="1" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre d'échéances <span class="text-danger">*</span></label>
                        <input type="number" name="nombre_echeances" class="form-control" value="9" min="1" max="12" required>
                        <small class="text-muted">Entre 1 et 12</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jour limite de paiement <span class="text-danger">*</span></label>
                        <input type="number" name="jour_limite" class="form-control" value="5" min="1" max="28" required>
                        <small class="text-muted">Jour du mois (1 à 28)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer le tarif</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals Modifier / Supprimer --}}
@foreach($tarifs as $tarif)
<div class="modal fade" id="editTarif{{ $tarif->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('recteur.tarifs.update', $tarif) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Montant total (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" name="montant_total" class="form-control" value="{{ $tarif->montant_total }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre d'échéances <span class="text-danger">*</span></label>
                        <input type="number" name="nombre_echeances" class="form-control" value="{{ $tarif->nombre_echeances }}" min="1" max="12" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jour limite <span class="text-danger">*</span></label>
                        <input type="number" name="jour_limite" class="form-control" value="{{ $tarif->jour_limite }}" min="1" max="28" required>
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

<div class="modal fade" id="deleteTarif{{ $tarif->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer le tarif <strong>{{ $tarif->anneeScolaire->libelle ?? '' }}</strong> ? Toutes les échéances associées seront supprimées.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('recteur.tarifs.destroy', $tarif) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
