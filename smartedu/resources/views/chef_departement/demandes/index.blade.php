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
                        <h3 class="page-title">Demandes étudiantes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Demandes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Créée le</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($demandes as $d)
                                    <tr>
                                        <td>{{ $d->etudiant?->user?->prenom ?? '' }} {{ $d->etudiant?->user?->nom ?? '' }}</td>
                                        <td>{{ $d->type }}</td>
                                        <td><span class="badge bg-secondary">{{ $d->statut }}</span></td>
                                        <td>{{ $d->created_at->format('d/m/Y') }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('chef_departement.demandes.show', $d) }}">Traiter</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune demande.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $demandes->links() }}</div>

        </div>
    </div>
</div>
@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>

