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
                        <h3 class="page-title">Délibérations</h3>
                    </div>
                </div>
            </div>

            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

            <div class="card mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('doyen.deliberations.lancer') }}" class="row g-2">
                        @csrf
                        <div class="col-md-4">
                            <select name="semestre_id" class="form-select" required>
                                <option value="">— Semestre —</option>
                                @foreach($semestres as $s)
                                    <option value="{{ $s->id }}">{{ $s->nom }} ({{ $s->numero }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="promotion_id" class="form-select" required>
                                <option value="">— Promotion —</option>
                                @foreach($promotions as $p)
                                    <option value="{{ $p->id }}">{{ $p->nom }} (N{{ $p->niveau }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary w-100">Lancer la délibération</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Semestre</th>
                                    <th class="text-center">Moyenne</th>
                                    <th>Décision</th>
                                    <th>Délibéré le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deliberations as $d)
                                    <tr>
                                        <td>{{ $d->etudiant?->user?->prenom ?? '' }} {{ $d->etudiant?->user?->nom ?? '' }}</td>
                                        <td>{{ $d->semestre->nom ?? '—' }}</td>
                                        <td class="text-center">{{ $d->moyenne ?? '—' }}</td>
                                        <td><span class="badge bg-secondary">{{ $d->decision }}</span></td>
                                        <td class="text-muted">{{ $d->delibere_le?->format('d/m/Y') ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune délibération.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $deliberations->links() }}</div>

        </div>
    </div>
</div>
@include("sections.doyen.profilModal")
@include("sections.doyen.script")
</body>
</html>

