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
                        <h3 class="page-title">Mes évaluations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes évaluations</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Intitulé</th>
                                    <th>Cours</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th class="text-center">Coefficient</th>
                                    <th class="text-center">Ma note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($evaluations as $eval)
                                    <tr>
                                        <td>{{ $eval->intitule }}</td>
                                        <td>{{ $eval->cours->intitule ?? '—' }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $eval->type ?? '—' }}</span>
                                        </td>
                                        <td>{{ $eval->date_evaluation ? \Carbon\Carbon::parse($eval->date_evaluation)->format('d/m/Y') : '—' }}</td>
                                        <td class="text-center">{{ $eval->coefficient ?? 1 }}</td>
                                        <td class="text-center">
                                            @if($eval->maNote !== null)
                                                <span class="badge {{ $eval->maNote >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    {{ number_format($eval->maNote, 2) }} / {{ $eval->note_max ?? 20 }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                            Aucune évaluation disponible.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
