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
                        <h3 class="page-title">Mes Notes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Notes</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                            <i class="fas fa-plus me-1"></i> Ajouter
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Étudiant</th>
                                            <th>Évaluation</th>
                                            <th>Cours</th>
                                            <th>Semestre</th>
                                            <th class="text-center">Note</th>
                                            <th>Commentaire</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($notes as $note)
                                        <tr>
                                            <td>{{ $note->etudiant->user->prenom ?? '—' }} {{ $note->etudiant->user->nom ?? '' }}
                                                <small class="text-muted d-block">{{ $note->etudiant_matricule }}</small>
                                            </td>
                                            <td>{{ $note->evaluation->titre ?? '—' }}</td>
                                            <td>{{ $note->evaluation->cours->titre ?? '—' }}</td>
                                            <td>{{ $note->semestre }}</td>
                                            <td class="text-center">
                                                @if($note->valeur >= 10)
                                                    <span class="badge bg-success">{{ $note->valeur }}/20</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $note->valeur }}/20</span>
                                                @endif
                                            </td>
                                            <td>{{ $note->commentaire ?? '—' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editNote{{ $note->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteNote{{ $note->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="7" class="text-center text-muted">Aucune note saisie.</td></tr>
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

<!-- Modal Ajouter -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.notes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select name="etudiant_matricule" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($etudiants as $et)
                                <option value="{{ $et->matricule }}">{{ $et->user->prenom }} {{ $et->user->nom }} ({{ $et->matricule }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Évaluation <span class="text-danger">*</span></label>
                            <select name="evaluation_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($evaluations as $eval)
                                <option value="{{ $eval->id }}">{{ $eval->cours->titre ?? '' }} — {{ $eval->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Note /20 <span class="text-danger">*</span></label>
                            <input type="number" name="valeur" class="form-control" step="0.01" min="0" max="20" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Semestre <span class="text-danger">*</span></label>
                            <select name="semestre" class="form-select" required>
                                @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Commentaire</label>
                            <input type="text" name="commentaire" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($notes as $note)
<!-- Modal Modifier -->
<div class="modal fade" id="editNote{{ $note->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.notes.update', $note->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant</label>
                            <select name="etudiant_matricule" class="form-select" required>
                                @foreach($etudiants as $et)
                                <option value="{{ $et->matricule }}" {{ $note->etudiant_matricule == $et->matricule ? 'selected' : '' }}>{{ $et->user->prenom }} {{ $et->user->nom }} ({{ $et->matricule }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Évaluation</label>
                            <select name="evaluation_id" class="form-select" required>
                                @foreach($evaluations as $eval)
                                <option value="{{ $eval->id }}" {{ $note->evaluation_id == $eval->id ? 'selected' : '' }}>{{ $eval->cours->titre ?? '' }} — {{ $eval->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Note /20</label>
                            <input type="number" name="valeur" class="form-control" step="0.01" min="0" max="20" value="{{ $note->valeur }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Semestre</label>
                            <select name="semestre" class="form-select" required>
                                @foreach(['S1','S2','S3','S4','S5','S6'] as $s)
                                <option value="{{ $s }}" {{ $note->semestre === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Commentaire</label>
                            <input type="text" name="commentaire" class="form-control" value="{{ $note->commentaire }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Supprimer -->
<div class="modal fade" id="deleteNote{{ $note->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Supprimer la note de <strong>{{ $note->valeur }}/20</strong> ?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('enseignant.notes.destroy', $note->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
