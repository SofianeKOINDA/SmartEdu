@include("sections.chef_departement.head")
<body>
<div class="main-wrapper">
    @include("sections.chef_departement.menuHaut")
    @include("sections.chef_departement.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Séances</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Séances</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('chef_departement.emploi_du_temps.index') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-calendar-alt me-1"></i> Emploi du temps
                        </a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSeanceModal">
                            <i class="fas fa-plus me-1"></i> Nouvelle séance
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                            <th>Cours</th>
                                            <th>Enseignant</th>
                                            <th>Promotion</th>
                                            <th>Jour</th>
                                            <th>Horaire</th>
                                            <th>Salle</th>
                                            <th>Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($seances as $seance)
                                        <tr>
                                            <td><strong>{{ $seance->cours->titre ?? '—' }}</strong></td>
                                            <td>{{ $seance->cours->enseignant->user->prenom ?? '' }} {{ $seance->cours->enseignant->user->nom ?? '—' }}</td>
                                            <td>{{ $seance->promotion->nom ?? '—' }}</td>
                                            <td class="text-capitalize">{{ $seance->jour }}</td>
                                            <td>{{ substr($seance->heure_debut, 0, 5) }} – {{ substr($seance->heure_fin, 0, 5) }}</td>
                                            <td>{{ $seance->salle ?? '—' }}</td>
                                            <td><span class="badge bg-secondary text-uppercase">{{ $seance->type }}</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editSeance{{ $seance->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteSeance{{ $seance->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="8" class="text-center text-muted">Aucune séance enregistrée.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $seances->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ajouter --}}
<div class="modal fade" id="addSeanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle séance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('chef_departement.seances.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cours <span class="text-danger">*</span></label>
                            <select name="cours_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($cours as $c)
                                <option value="{{ $c->id }}">{{ $c->titre }} ({{ $c->enseignant->user->nom ?? '?' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promotion <span class="text-danger">*</span></label>
                            <select name="promotion_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($promotions as $p)
                                <option value="{{ $p->id }}">{{ $p->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jour <span class="text-danger">*</span></label>
                            <select name="jour" class="form-select" required>
                                @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi'] as $j)
                                <option value="{{ $j }}">{{ ucfirst($j) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Heure début <span class="text-danger">*</span></label>
                            <input type="time" name="heure_debut" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Heure fin <span class="text-danger">*</span></label>
                            <input type="time" name="heure_fin" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Salle</label>
                            <input type="text" name="salle" class="form-control" placeholder="ex: A101">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="cm">CM</option>
                                <option value="td">TD</option>
                                <option value="tp">TP</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Récurrence</label>
                            <select name="recurrent" class="form-select" id="recurrentAdd">
                                <option value="1">Hebdomadaire</option>
                                <option value="0">Ponctuelle</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3" id="dateSpecifiqueAdd" style="display:none">
                            <label class="form-label">Date spécifique</label>
                            <input type="date" name="date_specifique" class="form-control">
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

{{-- Modals Modifier / Supprimer --}}
@foreach($seances as $seance)
<div class="modal fade" id="editSeance{{ $seance->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la séance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('chef_departement.seances.update', $seance) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cours</label>
                            <select name="cours_id" class="form-select" required>
                                @foreach($cours as $c)
                                <option value="{{ $c->id }}" {{ $seance->cours_id == $c->id ? 'selected' : '' }}>{{ $c->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Promotion</label>
                            <select name="promotion_id" class="form-select" required>
                                @foreach($promotions as $p)
                                <option value="{{ $p->id }}" {{ $seance->promotion_id == $p->id ? 'selected' : '' }}>{{ $p->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jour</label>
                            <select name="jour" class="form-select" required>
                                @foreach(['lundi','mardi','mercredi','jeudi','vendredi','samedi'] as $j)
                                <option value="{{ $j }}" {{ $seance->jour === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Heure début</label>
                            <input type="time" name="heure_debut" class="form-control" value="{{ $seance->heure_debut }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Heure fin</label>
                            <input type="time" name="heure_fin" class="form-control" value="{{ $seance->heure_fin }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Salle</label>
                            <input type="text" name="salle" class="form-control" value="{{ $seance->salle }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                @foreach(['cm','td','tp'] as $t)
                                <option value="{{ $t }}" {{ $seance->type === $t ? 'selected' : '' }}>{{ strtoupper($t) }}</option>
                                @endforeach
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

<div class="modal fade" id="deleteSeance{{ $seance->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer la séance de <strong>{{ $seance->cours->titre ?? '?' }}</strong> le {{ $seance->jour }} ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('chef_departement.seances.destroy', $seance) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
<script>
document.getElementById('recurrentAdd').addEventListener('change', function() {
    document.getElementById('dateSpecifiqueAdd').style.display = this.value === '0' ? 'block' : 'none';
});
</script>
</body>
</html>
