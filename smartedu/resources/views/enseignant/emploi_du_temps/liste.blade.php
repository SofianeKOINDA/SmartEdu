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
                        <h3 class="page-title">Mon emploi du temps</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Emploi du temps</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($seances as $jour => $items)
                    <div class="col-lg-6 mb-4">
                        <div class="card comman-shadow h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ ucfirst($jour) }}</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Heure</th>
                                                <th>Cours</th>
                                                <th>Promotion</th>
                                                <th>Salle</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $s)
                                                <tr>
                                                    <td class="text-muted">{{ substr($s->heure_debut,0,5) }}–{{ substr($s->heure_fin,0,5) }}</td>
                                                    <td>{{ $s->cours->intitule ?? '—' }}</td>
                                                    <td>{{ $s->promotion->nom ?? '—' }}</td>
                                                    <td>{{ $s->salle ?? '—' }}</td>
                                                    <td><span class="badge bg-secondary">{{ strtoupper($s->type) }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucune séance planifiée.
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>

