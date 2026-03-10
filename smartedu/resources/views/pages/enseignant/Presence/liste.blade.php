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
                        <h3 class="page-title">Mes Présences</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Présences</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPresenceModal">
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
                                            <th>Cours</th>
                                            <th>Date</th>
                                            <th class="text-center">Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($presences as $presence)
                                        <tr>
                                            <td>{{ $presence->etudiant->user->prenom ?? '—' }} {{ $presence->etudiant->user->nom ?? '' }}
                                                <small class="text-muted d-block">{{ $presence->etudiant_matricule }}</small>
                                            </td>
                                            <td>{{ $presence->cours->titre ?? '—' }}</td>
                                            <td>{{ $presence->date ? \Carbon\Carbon::parse($presence->date)->format('d/m/Y') : '—' }}</td>
                                            <td class="text-center">
                                                @if($presence->statut === 'present')
                                                    <span class="badge bg-success">Présent</span>
                                                @elseif($presence->statut === 'absent')
                                                    <span class="badge bg-danger">Absent</span>
                                                @elseif($presence->statut === 'retard')
                                                    <span class="badge bg-warning text-dark">Retard</span>
                                                @elseif($presence->statut === 'justifie')
                                                    <span class="badge bg-info text-dark">Justifié</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $presence->statut }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPresence{{ $presence->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deletePresence{{ $presence->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center text-muted">Aucune présence saisie.</td></tr>
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
<div class="modal fade" id="addPresenceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une présence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.presences.store') }}" method="POST">
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
                            <label class="form-label">Cours <span class="text-danger">*</span></label>
                            <select name="cours_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($cours as $c)
                                <option value="{{ $c->id }}">{{ $c->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut <span class="text-danger">*</span></label>
                            <select name="statut" class="form-select" required>
                                <option value="present">Présent</option>
                                <option value="absent">Absent</option>
                                <option value="retard">Retard</option>
                                <option value="justifie">Justifié</option>
                            </select>
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

@foreach($presences as $presence)
<!-- Modal Modifier -->
<div class="modal fade" id="editPresence{{ $presence->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la présence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('enseignant.presences.update', $presence->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étudiant</label>
                            <select name="etudiant_matricule" class="form-select" required>
                                @foreach($etudiants as $et)
                                <option value="{{ $et->matricule }}" {{ $presence->etudiant_matricule == $et->matricule ? 'selected' : '' }}>{{ $et->user->prenom }} {{ $et->user->nom }} ({{ $et->matricule }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cours</label>
                            <select name="cours_id" class="form-select" required>
                                @foreach($cours as $c)
                                <option value="{{ $c->id }}" {{ $presence->cours_id == $c->id ? 'selected' : '' }}>{{ $c->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $presence->date ? \Carbon\Carbon::parse($presence->date)->format('Y-m-d') : '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select" required>
                                <option value="present"  {{ $presence->statut === 'present'  ? 'selected' : '' }}>Présent</option>
                                <option value="absent"   {{ $presence->statut === 'absent'   ? 'selected' : '' }}>Absent</option>
                                <option value="retard"   {{ $presence->statut === 'retard'   ? 'selected' : '' }}>Retard</option>
                                <option value="justifie" {{ $presence->statut === 'justifie' ? 'selected' : '' }}>Justifié</option>
                            </select>
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
<div class="modal fade" id="deletePresence{{ $presence->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Supprimer cette présence ?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('enseignant.presences.destroy', $presence->id) }}" method="POST">
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
