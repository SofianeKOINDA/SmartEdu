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
                        <h3 class="page-title">Cours</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Cours</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCoursModal">
                            <i class="fas fa-plus me-1"></i> Ajouter un cours
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
                                            <th>Titre</th>
                                            <th>Type</th>
                                            <th>Enseignant</th>
                                            <th>Nb évaluations</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cours as $c)
                                        <tr>
                                            <td>{{ $c->titre }}</td>
                                            <td>{{ $c->type ?? '—' }}</td>
                                            <td>
                                                @if($c->enseignant && $c->enseignant->user)
                                                    {{ $c->enseignant->user->nom }} {{ $c->enseignant->user->prenom }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $c->evaluations_count }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCours{{ $c->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCours{{ $c->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucun cours enregistré.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $cours->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Ajouter -->
<div class="modal fade" id="addCoursModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un cours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cours.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" placeholder="Ex: CM, TD, TP...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Enseignant</label>
                            <select name="enseignant_matricule" class="form-select">
                                <option value="">-- Sélectionner un enseignant --</option>
                                @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->matricule_enseignant }}">
                                    {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} ({{ $enseignant->matricule_enseignant }})
                                </option>
                                @endforeach
                            </select>
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

@foreach($cours as $c)
<!-- Modal Modifier -->
<div class="modal fade" id="editCours{{ $c->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le cours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cours.update', $c->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="titre" class="form-control" value="{{ $c->titre }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" value="{{ $c->type }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $c->description }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Enseignant</label>
                            <select name="enseignant_matricule" class="form-select">
                                <option value="">-- Sélectionner un enseignant --</option>
                                @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->matricule_enseignant }}"
                                    {{ $c->enseignant && $c->enseignant->matricule_enseignant == $enseignant->matricule_enseignant ? 'selected' : '' }}>
                                    {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} ({{ $enseignant->matricule_enseignant }})
                                </option>
                                @endforeach
                            </select>
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
<div class="modal fade" id="deleteCours{{ $c->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer le cours <strong>{{ $c->titre }}</strong> ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('cours.destroy', $c->id) }}" method="POST">
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
