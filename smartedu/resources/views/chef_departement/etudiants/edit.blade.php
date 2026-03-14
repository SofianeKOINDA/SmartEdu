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
                        <h3 class="page-title">Modifier l’étudiant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.etudiants.index') }}">Étudiants</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('chef_departement.etudiants.update', $etudiant) }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Promotion</label>
                                <select name="promotion_id" class="form-select" required>
                                    @foreach($promotions as $p)
                                        <option value="{{ $p->id }}" {{ (old('promotion_id', $etudiant->promotion_id) == $p->id) ? 'selected' : '' }}>
                                            {{ $p->nom }} (N{{ $p->niveau }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro étudiant</label>
                                <input name="numero_etudiant" class="form-control" value="{{ old('numero_etudiant', $etudiant->numero_etudiant) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Actif</label>
                                <select name="actif" class="form-select" required>
                                    <option value="1" {{ old('actif', $etudiant->actif ? 1 : 0) == 1 ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ old('actif', $etudiant->actif ? 1 : 0) == 0 ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('chef_departement.etudiants.index') }}" class="btn btn-secondary">Annuler</a>
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

