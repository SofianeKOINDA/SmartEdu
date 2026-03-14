@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Tableau de bord SaaS</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-university fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbTenants }}</h2>
                                <p class="text-muted mb-0">Universités</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbAbonnements }}</h2>
                                <p class="text-muted mb-0">Abonnements actifs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3 bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                            <div>
                                <h2 class="mb-0 fw-bold">{{ $nbUsersTotal }}</h2>
                                <p class="text-muted mb-0">Utilisateurs total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-university me-2 text-primary"></i>Dernières universités</h5>
                            <a href="{{ route('super_admin.tenants.index') }}" class="btn btn-sm btn-outline-primary">Gérer tout</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Université</th>
                                            <th>Domaine</th>
                                            <th>Plan</th>
                                            <th>Créée le</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentsTenants as $tenant)
                                            <tr>
                                                <td>{{ $tenant->nom ?? $tenant->name ?? '—' }}</td>
                                                <td>{{ $tenant->domaine ?? $tenant->domain ?? '—' }}</td>
                                                <td>{{ $tenant->abonnements->first()?->plan?->nom ?? '—' }}</td>
                                                <td>{{ $tenant->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted py-4">Aucune université enregistrée.</td></tr>
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
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>
