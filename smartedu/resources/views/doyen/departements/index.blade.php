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
                        <h3 class="page-title">Départements</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('doyen.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Départements</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="{{ route('doyen.departements.create') }}">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Faculté</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departements as $d)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $d->nom }}</div>
                                            <div class="text-muted small">{{ $d->code ?? '—' }}</div>
                                        </td>
                                        <td>{{ $d->faculte->nom ?? '—' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('doyen.departements.edit', $d) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucun département.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $departements->links() }}</div>

        </div>
    </div>
</div>
@include("sections.doyen.profilModal")
@include("sections.doyen.script")
</body>
</html>

