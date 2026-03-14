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
                        <h3 class="page-title">Modifier la filière</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('chef_departement.filieres.update', $filiere) }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Département</label>
                                <select name="departement_id" class="form-select" required>
                                    @foreach($departements as $d)
                                        <option value="{{ $d->id }}" {{ old('departement_id', $filiere->departement_id) == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom', $filiere->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Code</label>
                                <input name="code" class="form-control" value="{{ old('code', $filiere->code) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Durée (années)</label>
                                <input type="number" name="duree_annees" class="form-control" value="{{ old('duree_annees', $filiere->duree_annees) }}" min="1" max="10" required>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('chef_departement.filieres.index') }}" class="btn btn-secondary">Annuler</a>
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

