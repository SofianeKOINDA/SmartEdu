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
                        <h3 class="page-title">Modifier l’enseignant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.enseignants.index') }}">Enseignants</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('chef_departement.enseignants.update', $enseignant) }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Département</label>
                                <select name="departement_id" class="form-select">
                                    <option value="">— Aucun —</option>
                                    @foreach($departements as $d)
                                        <option value="{{ $d->id }}" {{ old('departement_id', $enseignant->departement_id) == $d->id ? 'selected' : '' }}>
                                            {{ $d->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Grade</label>
                                <input name="grade" class="form-control" value="{{ old('grade', $enseignant->grade) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Spécialité</label>
                                <input name="specialite" class="form-control" value="{{ old('specialite', $enseignant->specialite) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Matricule</label>
                                <input name="matricule" class="form-control" value="{{ old('matricule', $enseignant->matricule) }}">
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('chef_departement.enseignants.index') }}" class="btn btn-secondary">Annuler</a>
                            <button class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>

