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
                        <h3 class="page-title">Mes Cours</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Cours</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($cours as $c)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 comman-shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $c->titre }}</h5>
                            <p class="text-muted mb-1">
                                <span class="badge bg-secondary">{{ $c->type ?? 'Cours' }}</span>
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-chalkboard-teacher me-1 text-primary"></i>
                                {{ $c->enseignant->user->prenom ?? '—' }} {{ $c->enseignant->user->nom ?? '' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-clock me-1 text-info"></i>
                                {{ $c->volume_horaire ?? '—' }}h
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-tasks me-1 text-warning"></i>
                                {{ $c->evaluations_count }} évaluation(s)
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">Aucun cours disponible pour votre classe.</div>
                </div>
                @endforelse
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
