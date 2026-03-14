@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <h3 class="page-title">Transactions PayTech</h3>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Référence</th>
                                    <th>Étudiant</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>PayTech ref</th>
                                    <th>Payé le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $t)
                                    <tr>
                                        <td class="fw-bold">{{ $t->reference }}</td>
                                        <td>{{ $t->etudiant?->user?->prenom ?? '' }} {{ $t->etudiant?->user?->nom ?? '' }}</td>
                                        <td>{{ number_format($t->montant, 0, ',', ' ') }} FCFA</td>
                                        <td><span class="badge bg-secondary">{{ $t->statut }}</span></td>
                                        <td class="text-muted">{{ $t->paytech_ref ?? '—' }}</td>
                                        <td>{{ $t->paye_le?->format('d/m/Y H:i') ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune transaction.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $transactions->links() }}</div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

