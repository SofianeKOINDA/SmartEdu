@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="page-title mb-0">Plans</h3>
                <a class="btn btn-primary" href="{{ route('super_admin.plans.create') }}">Ajouter</a>
            </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Nom</th><th>Prix mensuel</th><th>Actif</th><th class="text-end">Actions</th></tr></thead>
                            <tbody>
                                @forelse($plans as $p)
                                    <tr>
                                        <td class="fw-bold">{{ $p->nom }}</td>
                                        <td>{{ number_format($p->prix_mensuel, 0, ',', ' ') }} FCFA</td>
                                        <td><span class="badge {{ $p->actif ? 'bg-success' : 'bg-secondary' }}">{{ $p->actif ? 'Oui' : 'Non' }}</span></td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('super_admin.plans.edit', $p) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun plan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $plans->links() }}</div>
        </div>
    </div>
</div>
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>

