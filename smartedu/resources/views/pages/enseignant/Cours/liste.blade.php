@include("sections.enseignant.head")
<body>
<div class="main-wrapper">
    @include("sections.enseignant.menuHaut")
    @include("sections.enseignant.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mes Cours</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
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
                            <p class="mb-1"><span class="badge bg-secondary">{{ $c->type ?? 'Cours' }}</span></p>
                            <p class="mb-1 text-muted small">{{ $c->description ?? '' }}</p>
                            <hr>
                            <p class="mb-1">
                                <i class="fas fa-school me-1 text-primary"></i>
                                <strong>{{ $c->classes->count() }}</strong> classe(s) :
                                {{ $c->classes->pluck('nom')->implode(', ') ?: '—' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-tasks me-1 text-warning"></i>
                                {{ $c->evaluations_count }} évaluation(s)
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-calendar-check me-1 text-info"></i>
                                {{ $c->presences_count }} présence(s) saisie(s)
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">Aucun cours assigné.</div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
