@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Modifier enseignant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.enseignants.index') }}">Enseignants</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('recteur.enseignants.update', $enseignant) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input name="prenom" class="form-control" value="{{ old('prenom', $enseignant->user->prenom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom', $enseignant->user->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $enseignant->user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Département</label>
                                <select name="departement_id" class="form-select">
                                    <option value="">— Aucun —</option>
                                    @foreach($departements as $d)
                                        <option value="{{ $d->id }}" {{ old('departement_id', $enseignant->departement_id) == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
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
                            <a href="{{ route('recteur.enseignants.index') }}" class="btn btn-secondary">Annuler</a>
                            <button class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
