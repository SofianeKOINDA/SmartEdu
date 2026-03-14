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
                        <h3 class="page-title">Étudiants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Étudiants</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="{{ route('recteur.etudiants.create') }}">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form class="row g-2 mb-3" method="GET">
                        <div class="col-md-4">
                            <select name="promotion_id" class="form-select" onchange="this.form.submit()">
                                <option value="">— Toutes les promotions —</option>
                                @foreach($promotions as $p)
                                    <option value="{{ $p->id }}" {{ (string)$promotionId === (string)$p->id ? 'selected' : '' }}>
                                        {{ $p->nom }} (N{{ $p->niveau }})
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
                                    <th>Promotion</th>
                                    <th class="text-center">Actif</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $e)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $e->user->prenom ?? '' }} {{ $e->user->nom ?? '' }}</div>
                                            <div class="text-muted small">{{ $e->user->email ?? '—' }}</div>
                                        </td>
                                        <td>{{ $e->promotion->nom ?? '—' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $e->actif ? 'bg-success' : 'bg-secondary' }}">{{ $e->actif ? 'Oui' : 'Non' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('recteur.etudiants.show', $e) }}">Détail</a>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('recteur.etudiants.edit', $e) }}">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun étudiant.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $etudiants->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
