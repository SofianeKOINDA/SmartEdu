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
                        <h3 class="page-title">Présences — {{ $cours->intitule }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.cours.index') }}">Mes cours</a></li>
                            <li class="breadcrumb-item active">Présences</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAjoutPresence">
                            <i class="fas fa-plus me-1"></i> Saisir présence
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($datesSeances->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucune présence saisie pour ce cours.
                </div>
            @else
                @foreach($datesSeances as $dateSeance)
                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-day me-2 text-primary"></i>
                                Séance du {{ \Carbon\Carbon::parse($dateSeance)->format('d/m/Y') }}
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Étudiant</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-center">Modifier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($etudiants as $etudiant)
                                            @php
                                                $presence = $presences->get(\Carbon\Carbon::parse($dateSeance)->format('Y-m-d'))?->firstWhere('etudiant_id', $etudiant->id);
                                            @endphp
                                            <tr>
                                                <td>{{ ($etudiant->user->prenom ?? '') }} {{ ($etudiant->user->nom ?? '') }}</td>
                                                <td class="text-center">
                                                    @if($presence)
                                                        @php
                                                            $badge = match($presence->statut) {
                                                                'present'  => ['bg-success', 'Présent'],
                                                                'absent'   => ['bg-danger', 'Absent'],
                                                                'retard'   => ['bg-warning text-dark', 'Retard'],
                                                                'excuse'   => ['bg-info', 'Justifié'],
                                                                default    => ['bg-secondary', $presence->statut],
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($presence)
                                                        <button class="btn btn-sm btn-outline-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEditPresence{{ $presence->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>

{{-- Modal Ajout présence --}}
<div class="modal fade" id="modalAjoutPresence" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.presences.store') }}" method="POST">
            @csrf
            <input type="hidden" name="cours_id" value="{{ $cours->id }}">
            <input type="hidden" name="tenant_id" value="{{ auth()->user()->tenant_id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Saisir une présence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date de la séance <span class="text-danger">*</span></label>
                        <input type="date" name="date_seance" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                        <select name="etudiant_id" class="form-select" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($etudiants as $e)
                                <option value="{{ $e->id }}">{{ ($e->user->prenom ?? '') }} {{ ($e->user->nom ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut <span class="text-danger">*</span></label>
                        <select name="statut" class="form-select" required>
                            <option value="present">Présent</option>
                            <option value="absent">Absent</option>
                            <option value="retard">Retard</option>
                            <option value="excuse">Justifié</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modals Edit présence --}}
@foreach($presences->flatten() as $presence)
<div class="modal fade" id="modalEditPresence{{ $presence->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.presences.update', $presence) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la présence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">
                        Étudiant : <strong>{{ $presence->etudiant->user->name ?? '—' }}</strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
            @foreach(['present','absent','retard','excuse'] as $s)
                                <option value="{{ $s }}" {{ $presence->statut === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
