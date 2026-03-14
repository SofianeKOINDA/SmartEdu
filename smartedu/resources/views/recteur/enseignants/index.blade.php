@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Enseignants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Enseignants</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="{{ route('recteur.enseignants.create') }}">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Département</th>
                                    <th>Grade</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignants as $ens)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $ens->user->prenom ?? '' }} {{ $ens->user->nom ?? '' }}</div>
                                            <div class="text-muted small">{{ $ens->user->email ?? '—' }}</div>
                                        </td>
                                        <td>{{ $ens->departement->nom ?? '—' }}</td>
                                        <td>{{ $ens->grade ?? '—' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('recteur.enseignants.show', $ens) }}">Détail</a>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.enseignants.edit', $ens) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun enseignant.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $enseignants->links() }}</div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
