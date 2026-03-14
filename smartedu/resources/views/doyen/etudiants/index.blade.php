@include("sections.doyen.head")
<body>
<div class="main-wrapper">
    @include("sections.doyen.menuHaut")
    @include("sections.doyen.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header"><h3 class="page-title">Étudiants</h3></div>

            <div class="card mb-3">
                <div class="card-body">
                    <form class="row g-2" method="GET">
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
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Promotion</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($etudiants as $e)
                                    <tr>
                                        <td>{{ $e->user->prenom ?? '' }} {{ $e->user->nom ?? '' }}</td>
                                        <td>{{ $e->promotion->nom ?? '—' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('doyen.etudiants.show', $e) }}">Détail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucun étudiant.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $etudiants->links() }}</div>

        </div>
    </div>
</div>
@include("sections.doyen.profilModal")
@include("sections.doyen.script")
</body>
</html>

