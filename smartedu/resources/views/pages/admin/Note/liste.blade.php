@include("sections.admin.head")
<body>
<div class="main-wrapper">
    @include("sections.admin.menuHaut")
    @include("sections.admin.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Notes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Notes</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                            <i class="fas fa-plus me-1"></i> Ajouter une note
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
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
                                            <th>Valeur</th>
                                            <th>Semestre</th>
                                            <th>Commentaire</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($notes as $note)
                                        <tr>
                                            <td>
                                                @if($note->etudiant && $note->etudiant->user)
                                                    {{ $note->etudiant->user->nom }} {{ $note->etudiant->user->prenom }}
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $note->evaluation->titre ?? '—' }}</td>
                                            <td>{{ $note->valeur }}</td>
                                            <td>{{ $note->semestre ?? '—' }}</td>
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
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Aucune note enregistrée.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $notes->links() }}</div>
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
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select name="etudiant_matricule" class="form-select" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                <option value="{{ $etudiant->matricule }}">
                                    {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->matricule }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Évaluation <span class="text-danger">*</span></label>
                            <select name="evaluation_id" class="form-select" required>
                                <option value="">-- Sélectionner une évaluation --</option>
                                @foreach($evaluations as $evaluation)
                                <option value="{{ $evaluation->id }}">{{ $evaluation->titre }} ({{ $evaluation->cours->titre ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valeur <span class="text-danger">*</span></label>
                            <input type="number" name="valeur" class="form-control" step="0.01" min="0" max="20" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Semestre</label>
                            <input type="text" name="semestre" class="form-control" placeholder="Ex: S1, S2...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Commentaire</label>
                            <textarea name="commentaire" class="form-control" rows="2"></textarea>
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
            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant <span class="text-danger">*</span></label>
                            <select name="etudiant_matricule" class="form-select" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                <option value="{{ $etudiant->matricule }}"
                                    {{ $note->etudiant && $note->etudiant->matricule == $etudiant->matricule ? 'selected' : '' }}>
                                    {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} ({{ $etudiant->matricule }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Évaluation <span class="text-danger">*</span></label>
                            <select name="evaluation_id" class="form-select" required>
                                <option value="">-- Sélectionner une évaluation --</option>
                                @foreach($evaluations as $evaluation)
                                <option value="{{ $evaluation->id }}" {{ $note->evaluation_id == $evaluation->id ? 'selected' : '' }}>
                                    {{ $evaluation->titre }} ({{ $evaluation->cours->titre ?? '' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valeur <span class="text-danger">*</span></label>
                            <input type="number" name="valeur" class="form-control" step="0.01" min="0" max="20" value="{{ $note->valeur }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Semestre</label>
                            <input type="text" name="semestre" class="form-control" value="{{ $note->semestre }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Commentaire</label>
                            <textarea name="commentaire" class="form-control" rows="2">{{ $note->commentaire }}</textarea>
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
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer cette note (valeur : <strong>{{ $note->valeur }}</strong>) ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.admin.profilModal")
@include("sections.admin.script")
</body>
</html>
