@include("sections.admin.head")
<body>
<div class="main-wrapper">
    @include("sections.admin.menuHaut")
    @include("sections.admin.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Paiements</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Paiements</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaiementModal">
                            <i class="fas fa-plus me-1"></i> Ajouter un paiement
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Étudiant</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                            <th>Méthode</th>
                                            <th>Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paiements as $paiement)
                                        <tr>
                                            <td>
                                                @if($paiement->etudiant && $paiement->etudiant->user)
                                                    {{ $paiement->etudiant->user->nom }} {{ $paiement->etudiant->user->prenom }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ $paiement->date ? \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') : '—' }}</td>
                                            <td>
                                                @if($paiement->statut === 'valide')
                                                    <span class="badge bg-success">Validé</span>
                                                @elseif($paiement->statut === 'en_attente')
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @elseif($paiement->statut === 'rejete')
                                                    <span class="badge bg-danger">Rejeté</span>
                                                @else
                                                    {{ $paiement->statut ?? '—' }}
                                                @endif
                                            </td>
                                            <td>{{ $paiement->methode ?? '—' }}</td>
                                            <td>{{ $paiement->type ?? '—' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPaiement{{ $paiement->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePaiement{{ $paiement->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Aucun paiement enregistré.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $paiements->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Ajouter -->
<div class="modal fade" id="addPaiementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('paiements.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select name="etudiant_matricule" class="form-select" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                <option value="{{ $etudiant->matricule }}">
                                    {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->matricule }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Montant (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="en_attente">En attente</option>
                                <option value="valide">Validé</option>
                                <option value="rejete">Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Méthode</label>
                            <input type="text" name="methode" class="form-control" placeholder="Ex: Espèces, Virement, Mobile money...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" placeholder="Ex: Scolarité, Inscription...">
                        </div>
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

@foreach($paiements as $paiement)
<!-- Modal Modifier -->
<div class="modal fade" id="editPaiement{{ $paiement->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('paiements.update', $paiement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select name="etudiant_matricule" class="form-select" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                <option value="{{ $etudiant->matricule }}"
                                    {{ $paiement->etudiant && $paiement->etudiant->matricule == $etudiant->matricule ? 'selected' : '' }}>
                                    {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->matricule }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Montant (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" name="montant" class="form-control" min="0" value="{{ $paiement->montant }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ $paiement->date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="en_attente" {{ $paiement->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="valide" {{ $paiement->statut === 'valide' ? 'selected' : '' }}>Validé</option>
                                <option value="rejete" {{ $paiement->statut === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Méthode</label>
                            <input type="text" name="methode" class="form-control" value="{{ $paiement->methode }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" value="{{ $paiement->type }}">
                        </div>
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

<!-- Modal Supprimer -->
<div class="modal fade" id="deletePaiement{{ $paiement->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer ce paiement de <strong>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong> ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.admin.script")
</body>
</html>
