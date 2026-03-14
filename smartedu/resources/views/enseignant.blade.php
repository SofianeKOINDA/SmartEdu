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
                        <h3 class="page-title">Tableau de bord</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Stat cards --}}
            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-01.svg') }}" alt="">
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbCours }}</h2>
                                <p class="text-muted mb-0">Cours assignés</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-02.svg') }}" alt="">
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbEtudiants }}</h2>
                                <p class="text-muted mb-0">Étudiants suivis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-03.svg') }}" alt="">
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbEvaluations }}</h2>
                                <p class="text-muted mb-0">Évaluations créées</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Prochaines séances</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Heure</th>
                                            <th>Cours</th>
                                            <th>Promotion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prochainesSeances as $s)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($s->next_date)->format('d/m/Y') }}</td>
                                                <td class="text-muted">{{ substr($s->heure_debut,0,5) }}–{{ substr($s->heure_fin,0,5) }}</td>
                                                <td>{{ $s->cours->intitule ?? '—' }}</td>
                                                <td>{{ $s->promotion->nom ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted py-4">Aucune séance.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Taux de présence moyen</h5>
                            <a href="{{ route('enseignant.cours.index') }}" class="btn btn-sm btn-outline-primary">Voir les cours</a>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <div class="display-6 fw-bold {{ ($tauxPresenceMoyen ?? 0) >= 75 ? 'text-success' : 'text-danger' }}">
                                    {{ $tauxPresenceMoyen !== null ? $tauxPresenceMoyen.'%' : '—' }}
                                </div>
                                <div class="text-muted">sur toutes les présences saisies</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Mes cours --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-book-reader me-2 text-primary"></i>Mes cours</h5>
                            <a href="{{ route('enseignant.cours.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($cours->take(5) as $c)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $c->intitule }}</strong>
                                            <br><small class="text-muted">{{ $c->ue->intitule ?? '—' }}</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $c->evaluations->count() }} éval.</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted text-center py-3">Aucun cours assigné.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Dernières évaluations --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-warning"></i>Dernières évaluations</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($dernieresEvaluations as $eval)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $eval->intitule }}</strong>
                                            <br><small class="text-muted">{{ $eval->cours->intitule ?? '—' }}</small>
                                        </div>
                                        <small class="text-muted">{{ $eval->created_at->format('d/m/Y') }}</small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted text-center py-3">Aucune évaluation.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
