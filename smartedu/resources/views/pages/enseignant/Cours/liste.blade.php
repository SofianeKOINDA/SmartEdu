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

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

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
                            <p class="mb-2">
                                <i class="fas fa-calendar-check me-1 text-info"></i>
                                {{ $c->presences_count }} présence(s) saisie(s)
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <button class="btn btn-sm btn-outline-primary w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#gererClasses{{ $c->id }}">
                                <i class="fas fa-school me-1"></i> Gérer les classes
                            </button>
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

{{-- Modals Gérer Classes --}}
@foreach($cours as $c)
<div class="modal fade" id="gererClasses{{ $c->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Classes — {{ $c->titre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.cours.classes.sync', $c->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">Cochez les classes qui suivent ce cours :</p>
                    @forelse($toutesClasses as $classe)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox"
                            name="classe_ids[]"
                            value="{{ $classe->id }}"
                            id="cl{{ $c->id }}_{{ $classe->id }}"
                            {{ $c->classes->contains('id', $classe->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cl{{ $c->id }}_{{ $classe->id }}">
                            {{ $classe->nom }}
                            @if($classe->niveau) <small class="text-muted">({{ $classe->niveau }})</small> @endif
                            <small class="text-muted ms-1">— {{ $classe->etudiants_count ?? $classe->etudiants->count() }} étudiant(s)</small>
                        </label>
                    </div>
                    @empty
                    <p class="text-muted">Aucune classe disponible.</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
