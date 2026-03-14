@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h3 class="page-title mb-0">Facultés</h3>
                <a class="btn btn-primary" href="{{ route('recteur.facultes.create') }}">Ajouter</a>
            </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Nom</th><th>Code</th><th class="text-end">Actions</th></tr></thead>
                            <tbody>
                                @forelse($facultes as $f)
                                    <tr>
                                        <td class="fw-bold">{{ $f->nom }}</td>
                                        <td class="text-muted">{{ $f->code ?? '—' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.facultes.edit', $f) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucune faculté.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $facultes->links() }}</div>
        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

