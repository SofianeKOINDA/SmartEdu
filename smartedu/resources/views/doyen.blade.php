@include("sections.doyen.head")
<body>
<div class="main-wrapper">
    @include("sections.doyen.menuHaut")
    @include("sections.doyen.menuGauche")
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

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbFacultes }}</h2>
                                <p class="text-muted mb-0">Facultés</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-sitemap fa-2x text-info"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbDepartements }}</h2>
                                <p class="text-muted mb-0">Départements</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbEnseignants }}</h2>
                                <p class="text-muted mb-0">Enseignants</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-user-graduate fa-2x text-warning"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbEtudiants }}</h2>
                                <p class="text-muted mb-0">Étudiants</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-building me-2 text-primary"></i>Facultés</h5>
                            <a href="{{ route('doyen.facultes.index') }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Faculté</th>
                                            <th class="text-center">Départements</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($facultes as $f)
                                            <tr>
                                                <td>{{ $f->libelle ?? $f->nom ?? '—' }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">{{ $f->departements->count() }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="2" class="text-center text-muted py-4">Aucune faculté.</td></tr>
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
@include("sections.doyen.profilModal")
@include("sections.doyen.script")
</body>
</html>
