@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Abonnements</h3></div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Université</th><th>Plan</th><th>Statut</th><th>Début</th><th>Fin</th><th>Montant</th></tr>
                            </thead>
                            <tbody>
                                @forelse($abonnements as $a)
                                    <tr>
                                        <td>{{ $a->tenant->nom ?? '—' }}</td>
                                        <td>{{ $a->plan->nom ?? '—' }}</td>
                                        <td><span class="badge bg-secondary">{{ $a->statut }}</span></td>
                                        <td>{{ $a->date_debut?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ $a->date_fin?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ number_format($a->montant, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Aucun abonnement.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $abonnements->links() }}</div>
        </div>
    </div>
</div>
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>

