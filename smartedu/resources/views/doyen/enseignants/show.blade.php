@include("sections.doyen.head")
<body>
<div class="main-wrapper">
    @include("sections.doyen.menuHaut")
    @include("sections.doyen.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header"><h3 class="page-title">Détail enseignant</h3></div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="fw-bold">{{ $enseignant->user->prenom ?? '' }} {{ $enseignant->user->nom ?? '' }}</div>
                    <div class="text-muted">{{ $enseignant->user->email ?? '—' }}</div>
                    <div><strong>Département:</strong> {{ $enseignant->departement->nom ?? '—' }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light"><h5 class="mb-0">Cours</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light"><tr><th>Cours</th><th>UE</th></tr></thead>
                            <tbody>
                                @forelse($enseignant->cours as $c)
                                    <tr><td>{{ $c->intitule }}</td><td>{{ $c->ue->nom ?? '—' }}</td></tr>
                                @empty
                                    <tr><td colspan="2" class="text-center text-muted py-4">Aucun cours.</td></tr>
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

