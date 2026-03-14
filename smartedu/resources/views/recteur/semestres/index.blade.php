@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="page-title mb-0">Semestres</h3>
                <a class="btn btn-primary" href="{{ route('recteur.semestres.create') }}">Ajouter</a>
            </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Nom</th><th>Année</th><th class="text-center">N°</th><th class="text-end">Actions</th></tr>
                            </thead>
                            <tbody>
                                @forelse($semestres as $s)
                                    <tr>
                                        <td class="fw-bold">{{ $s->nom }}</td>
                                        <td>{{ $s->anneeScolaire?->libelle ?? '—' }}</td>
                                        <td class="text-center">{{ $s->numero }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.semestres.edit', $s) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun semestre.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $semestres->links() }}</div>
        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

