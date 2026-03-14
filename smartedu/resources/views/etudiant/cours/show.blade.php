@include("sections.etudiant.head")
<body>
<div class="main-wrapper">
    @include("sections.etudiant.menuHaut")
    @include("sections.etudiant.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">{{ $cours->intitule }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.cours.index') }}">Mes cours</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Informations du cours</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>UE :</strong> {{ $cours->ue->nom ?? '—' }}</p>
                            <p class="mb-2"><strong>Semestre :</strong> {{ $cours->ue->semestre->nom ?? '—' }}</p>
                            <p class="mb-2"><strong>Volume horaire :</strong> {{ $cours->volume_horaire ?? '—' }} h</p>
                            <p class="mb-0"><strong>Coefficient :</strong> {{ $cours->coefficient ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-warning"></i>Évaluations</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Intitulé</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th class="text-center">Coeff.</th>
                                            <th class="text-center">Barème</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cours->evaluations as $e)
                                            <tr>
                                                <td>{{ $e->intitule }}</td>
                                                <td><span class="badge bg-secondary">{{ $e->type }}</span></td>
                                                <td>{{ $e->date_evaluation ? \Carbon\Carbon::parse($e->date_evaluation)->format('d/m/Y') : '—' }}</td>
                                                <td class="text-center">{{ $e->coefficient ?? 1 }}</td>
                                                <td class="text-center">{{ $e->note_max ?? 20 }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-muted py-4">Aucune évaluation.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card comman-shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user-tie me-2 text-info"></i>Enseignant</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Nom :</strong> {{ $cours->enseignant?->user?->prenom ?? '—' }} {{ $cours->enseignant?->user?->nom ?? '' }}</p>
                            <p class="mb-0"><strong>Grade :</strong> {{ $cours->enseignant?->grade ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>

