@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="page-title mb-0">Années scolaires</h3>
                <a class="btn btn-primary" href="{{ route('recteur.annees-scolaires.create') }}">Ajouter</a>
            </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Libellé</th><th>Début</th><th>Fin</th><th class="text-center">Courante</th><th class="text-end">Actions</th></tr>
                            </thead>
                            <tbody>
                                @forelse($annees as $a)
                                    <tr>
                                        <td class="fw-bold">{{ $a->libelle }}</td>
                                        <td>{{ $a->date_debut?->format('d/m/Y') }}</td>
                                        <td>{{ $a->date_fin?->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $a->courante ? 'bg-success' : 'bg-secondary' }}">{{ $a->courante ? 'Oui' : 'Non' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.annees-scolaires.edit', $a) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune année.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $annees->links() }}</div>
        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

