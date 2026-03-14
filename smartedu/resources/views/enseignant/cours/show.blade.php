@include("sections.enseignant.head")
<body>
<div class="main-wrapper">
    @include("sections.enseignant.menuHaut")
    @include("sections.enseignant.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ $cours->intitule }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.cours.index') }}">Mes cours</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Infos</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>UE :</strong> {{ $cours->ue->nom ?? '—' }}</p>
                            <p class="mb-2"><strong>Semestre :</strong> {{ $cours->ue->semestre->nom ?? '—' }}</p>
                            <p class="mb-2"><strong>Volume horaire :</strong> {{ $cours->volume_horaire ?? '—' }} h</p>
                            <p class="mb-0"><strong>Étudiants inscrits :</strong> {{ $cours->etudiants->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-users me-2 text-info"></i>Étudiants</h5>
                            <a href="{{ route('enseignant.presences.index', $cours) }}" class="btn btn-sm btn-outline-success">
                                Présences
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cours->etudiants as $e)
                                            <tr>
                                                <td>{{ ($e->user->prenom ?? '') }} {{ ($e->user->nom ?? '') }}</td>
                                                <td class="text-muted">{{ $e->user->email ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="2" class="text-center text-muted py-4">Aucun étudiant.</td></tr>
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
@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>

