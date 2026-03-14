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
                        <h3 class="page-title">Échéances</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Échéances</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-outline-success" href="{{ route('recteur.echeances.export') }}">
                            <i class="fas fa-file-excel me-1"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Année</th>
                                    <th>Mois</th>
                                    <th>Montant</th>
                                    <th>Date limite</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($echeances as $e)
                                    <tr>
                                        <td>{{ $e->etudiant?->user?->prenom ?? '' }} {{ $e->etudiant?->user?->nom ?? '' }}</td>
                                        <td>{{ $e->tarif?->anneeScolaire?->libelle ?? '—' }}</td>
                                        <td>M{{ $e->numero_mois }}</td>
                                        <td>{{ number_format($e->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>{{ $e->date_limite?->format('d/m/Y') ?? '—' }}</td>
                                        <td><span class="badge bg-secondary">{{ $e->statut }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune échéance.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $echeances->links() }}</div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

