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
                        <h3 class="page-title">Mes cours</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes cours</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                @forelse($cours as $c)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 text-truncate">{{ $c->intitule }}</h6>
                                <span class="badge bg-light text-dark">{{ strtoupper($c->type ?? 'CM') }}</span>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">
                                    <i class="fas fa-book me-1 text-muted"></i>
                                    <strong>UE :</strong> {{ $c->ue->intitule ?? '—' }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-layer-group me-1 text-muted"></i>
                                    <strong>Semestre :</strong> {{ $c->ue->semestre->libelle ?? '—' }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-user-tie me-1 text-muted"></i>
                                    <strong>Enseignant :</strong> {{ $c->enseignant->user->name ?? '—' }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    <strong>Volume horaire :</strong> {{ $c->volume_horaire ?? '—' }} h
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-clipboard-list me-1 text-muted"></i>
                                    <strong>Évaluations :</strong> {{ $c->evaluations->count() }}
                                </p>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="{{ route('etudiant.cours.show', $c) }}" class="btn btn-sm btn-outline-primary w-100">
                                    Voir le détail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun cours inscrit pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
