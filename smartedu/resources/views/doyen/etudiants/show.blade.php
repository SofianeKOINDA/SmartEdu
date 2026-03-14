@include("sections.doyen.head")
<body>
<div class="main-wrapper">
    @include("sections.doyen.menuHaut")
    @include("sections.doyen.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header"><h3 class="page-title">Détail étudiant</h3></div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="fw-bold">{{ $etudiant->user->prenom ?? '' }} {{ $etudiant->user->nom ?? '' }}</div>
                    <div class="text-muted">{{ $etudiant->user->email ?? '—' }}</div>
                    <div><strong>Promotion:</strong> {{ $etudiant->promotion->nom ?? '—' }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light"><h5 class="mb-0">Délibérations</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Semestre</th><th>Moyenne</th><th>Décision</th></tr></thead>
                            <tbody>
                                @forelse($etudiant->deliberations as $d)
                                    <tr>
                                        <td>{{ $d->semestre->nom ?? '—' }}</td>
                                        <td>{{ $d->moyenne ?? '—' }}</td>
                                        <td><span class="badge bg-secondary">{{ $d->decision }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucune délibération.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
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

