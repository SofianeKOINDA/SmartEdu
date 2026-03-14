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
                        <h3 class="page-title">Mes présences</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes présences</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Taux global --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="text-{{ $tauxGlobal >= 75 ? 'success' : 'danger' }} fw-bold mb-0">
                                {{ number_format($tauxGlobal, 1) }}%
                            </h2>
                            <p class="text-muted mb-0">Taux de présence global</p>
                        </div>
                    </div>
                </div>
            </div>

            @forelse($presencesParCours as $coursIntitule => $data)
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-book me-2 text-primary"></i>{{ $coursIntitule }}</h5>
                        <span class="badge {{ $data['taux'] >= 75 ? 'bg-success' : 'bg-danger' }} fs-6">
                            Taux : {{ number_format($data['taux'], 1) }}%
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['presences'] as $presence)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($presence->date_seance)->format('d/m/Y') }}</td>
                                            <td class="text-muted">—</td>
                                            <td class="text-center">
                                                @php
                                                    $badge = match($presence->statut) {
                                                        'present'  => ['bg-success', 'Présent'],
                                                        'absent'   => ['bg-danger', 'Absent'],
                                                        'retard'   => ['bg-warning text-dark', 'Retard'],
                                                        'justifié' => ['bg-info', 'Justifié'],
                                                        default    => ['bg-secondary', $presence->statut],
                                                    };
                                                @endphp
                                                <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucune donnée de présence disponible.
                </div>
            @endforelse

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
