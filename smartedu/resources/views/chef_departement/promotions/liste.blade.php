@include("sections.chef_departement.head")
<body>
<div class="main-wrapper">
    @include("sections.chef_departement.menuHaut")
    @include("sections.chef_departement.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Promotions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.seances.index') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">Promotions</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
                            <i class="fas fa-plus me-1"></i> Nouvelle promotion
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                            <th>Nom</th>
                                            <th>Filière</th>
                                            <th>Année scolaire</th>
                                            <th>Niveau</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($promotions as $promotion)
                                        <tr>
                                            <td><strong>{{ $promotion->nom }}</strong></td>
                                            <td>{{ $promotion->filiere->nom ?? '—' }}</td>
                                            <td>{{ $promotion->anneeScolaire->libelle ?? '—' }}</td>
                                            <td>{{ $promotion->niveau ?? '—' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPromotion{{ $promotion->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePromotion{{ $promotion->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center text-muted">Aucune promotion enregistrée.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $promotions->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ajouter --}}
<div class="modal fade" id="addPromotionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('chef_departement.promotions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control" placeholder="ex: L1 Info 2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Filière <span class="text-danger">*</span></label>
                        <select name="filiere_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <label class="form-label">Niveau</label>
                        <input type="text" name="niveau" class="form-control" placeholder="ex: L1, L2, M1">
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

{{-- Modals Modifier / Supprimer --}}
@foreach($promotions as $promotion)
<div class="modal fade" id="editPromotion{{ $promotion->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier — {{ $promotion->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('chef_departement.promotions.update', $promotion) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control" value="{{ $promotion->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Filière <span class="text-danger">*</span></label>
                        <select name="filiere_id" class="form-select" required>
                            @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ $promotion->filiere_id == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Année scolaire <span class="text-danger">*</span></label>
                        <select name="annee_scolaire_id" class="form-select" required>
                            @foreach($anneesScolaires as $annee)
                            <option value="{{ $annee->id }}" {{ $promotion->annee_scolaire_id == $annee->id ? 'selected' : '' }}>{{ $annee->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Niveau</label>
                        <input type="text" name="niveau" class="form-control" value="{{ $promotion->niveau }}">
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

<div class="modal fade" id="deletePromotion{{ $promotion->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer <strong>{{ $promotion->nom }}</strong> ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('chef_departement.promotions.destroy', $promotion) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>
