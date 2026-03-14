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
                        <h3 class="page-title">Détail enseignant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.enseignants.index') }}">Enseignants</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef_departement.enseignants.edit', $enseignant) }}" class="btn btn-outline-primary">Modifier</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light"><h5 class="mb-0">Profil</h5></div>
                        <div class="card-body">
                            <div class="fw-bold">{{ $enseignant->user->prenom ?? '' }} {{ $enseignant->user->nom ?? '' }}</div>
                            <div class="text-muted">{{ $enseignant->user->email ?? '—' }}</div>
                            <hr>
                            <div><strong>Département :</strong> {{ $enseignant->departement->nom ?? '—' }}</div>
                            <div><strong>Grade :</strong> {{ $enseignant->grade ?? '—' }}</div>
                            <div><strong>Spécialité :</strong> {{ $enseignant->specialite ?? '—' }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light"><h5 class="mb-0">Cours affectés</h5></div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Cours</th>
                                            <th>UE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enseignant->cours as $c)
                                            <tr>
                                                <td>{{ $c->intitule }}</td>
                                                <td class="text-muted">{{ $c->ue->nom ?? '—' }}</td>
                                            </tr>
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
    </div>
</div>
@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>

