@include("sections.chef_departement.head")
<body>
<div class="main-wrapper">
    @include("sections.chef_departement.menuHaut")
    @include("sections.chef_departement.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Détail étudiant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.etudiants.index') }}">Étudiants</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef_departement.etudiants.edit', $etudiant) }}" class="btn btn-outline-primary">Modifier</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Profil</h5>
                        </div>
                        <div class="card-body">
                            <div class="fw-bold">{{ $etudiant->user->prenom ?? '' }} {{ $etudiant->user->nom ?? '' }}</div>
                            <div class="text-muted">{{ $etudiant->user->email ?? '—' }}</div>
                            <hr>
                            <div><strong>Promotion :</strong> {{ $etudiant->promotion->nom ?? '—' }}</div>
                            <div><strong>Numéro :</strong> {{ $etudiant->numero_etudiant ?? '—' }}</div>
                            <div><strong>Actif :</strong> {{ $etudiant->actif ? 'Oui' : 'Non' }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Paiements (échéances)</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mois</th>
                                            <th>Montant</th>
                                            <th>Date limite</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiant->echeances->sortBy('numero_mois') as $e)
                                            <tr>
                                                <td>Mois {{ $e->numero_mois }}</td>
                                                <td>{{ number_format($e->montant, 0, ',', ' ') }} FCFA</td>
                                                <td>{{ \Carbon\Carbon::parse($e->date_limite)->format('d/m/Y') }}</td>
                                                <td><span class="badge bg-secondary">{{ $e->statut }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted py-4">Aucune échéance.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Dernières notes</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Évaluation</th>
                                            <th>Cours</th>
                                            <th class="text-center">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiant->notes->sortByDesc('created_at')->take(10) as $n)
                                            <tr>
                                                <td>{{ $n->evaluation->intitule ?? '—' }}</td>
                                                <td>{{ $n->evaluation->cours->intitule ?? '—' }}</td>
                                                <td class="text-center">{{ number_format($n->valeur, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted py-4">Aucune note.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>

