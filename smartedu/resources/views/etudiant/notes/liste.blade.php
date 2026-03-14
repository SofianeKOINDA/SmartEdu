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
                        <h3 class="page-title">Mes notes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes notes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card comman-shadow text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Moyenne générale</h6>
                            <h4 class="{{ ($moyenneGenerale ?? 0) >= 10 ? 'text-success' : 'text-danger' }}">
                                {{ $moyenneGenerale !== null ? number_format($moyenneGenerale, 2) . ' / 20' : '—' }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            @forelse($notesParUe as $ueNom => $notes)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-book me-2 text-primary"></i>{{ $ueNom }}</h5>
                            <span class="badge bg-info">
                                Moyenne UE: {{ $moyennesParUe[$ueNom] !== null ? number_format($moyennesParUe[$ueNom], 2) . ' / 20' : '—' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Évaluation</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th class="text-center">Note</th>
                                        <th class="text-center">Coefficient</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notes as $note)
                                        <tr>
                                            <td>{{ $note->evaluation->intitule ?? '—' }}</td>
                                            <td>{{ $note->evaluation->type ?? '—' }}</td>
                                            <td>{{ $note->evaluation->date_evaluation ? \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m/Y') : '—' }}</td>
                                            <td class="text-center">
                                                @php $val = $note->valeur; @endphp
                                                <span class="badge {{ $val >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    {{ number_format($val, 2) }} / {{ $note->evaluation->note_max ?? 20 }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $note->evaluation->coefficient ?? 1 }}</td>
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
                    Aucune note disponible pour le moment.
                </div>
            @endforelse

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
