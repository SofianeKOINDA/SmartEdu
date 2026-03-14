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
                        <h3 class="page-title">UEs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">UEs</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="{{ route('recteur.ues.create') }}">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form class="row g-2 mb-3" method="GET">
                        <div class="col-md-4">
                            <select name="semestre_id" class="form-select" onchange="this.form.submit()">
                                <option value="">— Tous les semestres —</option>
                                @foreach($semestres as $s)
                                    <option value="{{ $s->id }}" {{ (string)$semestreId === (string)$s->id ? 'selected' : '' }}>
                                        {{ $s->nom }} ({{ $s->numero }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Semestre</th>
                                    <th class="text-center">Coeff.</th>
                                    <th class="text-center">Crédits</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ues as $ue)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $ue->nom }}</div>
                                            <div class="text-muted small">{{ $ue->code ?? '—' }}</div>
                                        </td>
                                        <td>{{ $ue->semestre->nom ?? '—' }}</td>
                                        <td class="text-center">{{ $ue->coefficient }}</td>
                                        <td class="text-center">{{ $ue->credit }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.ues.edit', $ue) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Aucune UE.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $ues->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
