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
                        <h3 class="page-title">Tableau de bord</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Stat cards --}}
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbPromotions }}</h2>
                                <p class="text-muted mb-0">Promotions</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-graduation-cap fa-2x text-success"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbEtudiants }}</h2>
                                <p class="text-muted mb-0">Étudiants</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-book-open fa-2x text-info"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbCours }}</h2>
                                <p class="text-muted mb-0">Cours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbSeances }}</h2>
                                <p class="text-muted mb-0">Séances planifiées</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Prochaines séances --}}
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Prochaines séances</h5>
                            <a href="{{ route('chef_departement.seances.index') }}" class="btn btn-sm btn-outline-primary">Gérer les séances</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Cours</th>
                                            <th>Promotion</th>
                                            <th>Date</th>
                                            <th>Heure</th>
                                            <th>Salle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prochainesSeances as $seance)
                                            <tr>
                                                <td>{{ $seance->cours->intitule ?? '—' }}</td>
                                                <td>{{ $seance->promotion->libelle ?? '—' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($seance->next_date ?? $seance->date_specifique)->format('d/m/Y') }}</td>
                                                <td>{{ $seance->heure_debut ?? '—' }} – {{ $seance->heure_fin ?? '—' }}</td>
                                                <td>{{ $seance->salle ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    Aucune séance planifiée à venir.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>
