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
                        <h3 class="page-title">Ma Classe</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ma Classe</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(!$classe)
            <div class="alert alert-warning">Vous n'êtes pas encore affecté(e) à une classe.</div>
            @else

            <!-- Infos classe -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-school me-2 text-primary"></i>
                                {{ $classe->nom }}
                            </h5>
                            <p class="mb-1"><strong>Niveau :</strong> {{ $classe->niveau ?? '—' }}</p>
                            <p class="mb-1"><strong>Filière :</strong> {{ $classe->filiere ?? '—' }}</p>
                            <p class="mb-0">
                                <strong>Effectif :</strong>
                                <span class="badge bg-primary">{{ $classe->etudiants->count() }} étudiant(s)</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-book me-2 text-success"></i>
                                Cours dispensés
                            </h5>
                            <ul class="list-unstyled mb-0">
                                @forelse($classe->cours as $c)
                                <li class="mb-1">
                                    <i class="fas fa-circle text-primary me-1" style="font-size:0.5rem; vertical-align: middle;"></i>
                                    {{ $c->titre }}
                                    <small class="text-muted ms-1">— {{ $c->enseignant->user->prenom ?? '' }} {{ $c->enseignant->user->nom ?? '—' }}</small>
                                </li>
                                @empty
                                <li class="text-muted">Aucun cours associé.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des camarades -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-users me-2"></i>
                                Camarades de classe
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Matricule</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($classe->etudiants as $cam)
                                        <tr class="{{ $cam->id === $etudiant->id ? 'table-primary fw-bold' : '' }}">
                                            <td>{{ $cam->matricule }}</td>
                                            <td>{{ $cam->user->nom }}</td>
                                            <td>
                                                {{ $cam->user->prenom }}
                                                @if($cam->id === $etudiant->id)
                                                    <span class="badge bg-primary ms-1">Vous</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Aucun camarade.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

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
