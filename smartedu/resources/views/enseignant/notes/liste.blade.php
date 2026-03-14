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
                        <h3 class="page-title">Notes — {{ $evaluation->intitule }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.cours.index') }}">Mes cours</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('enseignant.evaluations.index', $evaluation->cours_id) }}">Évaluations</a>
                            </li>
                            <li class="breadcrumb-item active">Notes</li>
                        </ul>
                    </div>
                    <div class="col-auto d-flex gap-2">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalImportCsv">
                            <i class="fas fa-file-upload me-1"></i> Import CSV
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

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Type :</strong> {{ $evaluation->type ?? '—' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Date :</strong> {{ $evaluation->date_evaluation ? \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') : '—' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Coefficient :</strong> {{ $evaluation->coefficient ?? 1 }}
                        </div>
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
                                    <th class="text-center">Note / 20</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiants as $etudiant)
                                    @php $note = $notes->get($etudiant->id); @endphp
                                    <tr>
                                        <td>{{ ($etudiant->user->prenom ?? '') }} {{ ($etudiant->user->nom ?? '') }}</td>
                                        <td class="text-center">
                                            @if($note)
                                                <span class="badge {{ $note->valeur >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    {{ number_format($note->valeur, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Non saisie</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($note)
                                                <button class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditNote{{ $note->id }}">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalAjoutNote{{ $etudiant->id }}">
                                                    <i class="fas fa-plus"></i> Saisir
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

        </div>
    </div>
</div>

{{-- Modals ajout note par étudiant --}}
@foreach($etudiants as $etudiant)
    @if(!$notes->has($etudiant->id))
    <div class="modal fade" id="modalAjoutNote{{ $etudiant->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('enseignant.notes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">
                <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
                <input type="hidden" name="tenant_id" value="{{ auth()->user()->tenant_id }}">
                <div class="modal-content">
                    <div class="modal-header">
                                <h5 class="modal-title">Note — {{ ($etudiant->user->prenom ?? '') }} {{ ($etudiant->user->nom ?? '') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Note / 20 <span class="text-danger">*</span></label>
                            <input type="number" name="valeur" class="form-control"
                                   step="0.25" min="0" max="20" required>
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
    @endif
@endforeach

{{-- Modals edit note --}}
@foreach($notes as $note)
<div class="modal fade" id="modalEditNote{{ $note->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.notes.update', $note) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">
                        Étudiant :
                        <strong>{{ ($note->etudiant->user->prenom ?? '') }} {{ ($note->etudiant->user->nom ?? '') }}</strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label">Note / 20</label>
                        <input type="number" name="valeur" class="form-control"
                               value="{{ $note->valeur }}" step="0.25" min="0" max="20" required>
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

{{-- Modal import CSV --}}
<div class="modal fade" id="modalImportCsv" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.notes.import', $evaluation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        Colonnes attendues: <strong>valeur</strong> + <strong>etudiant_id</strong> (ou <strong>email</strong>).
                    </div>
                    <input type="file" name="csv" class="form-control" accept=".csv,text/csv" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Importer</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
