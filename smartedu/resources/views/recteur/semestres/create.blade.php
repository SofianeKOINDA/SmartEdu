@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Créer un semestre</h3></div>
            <div class="card"><div class="card-body">
                <form method="POST" action="{{ route('recteur.semestres.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                @foreach($annees as $a)
                                    <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input name="nom" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Numéro</label>
                            <input type="number" name="numero" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Actif</label>
                            <select name="actif" class="form-select">
                                <option value="0" selected>Non</option>
                                <option value="1">Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a class="btn btn-secondary" href="{{ route('recteur.semestres.index') }}">Annuler</a>
                        <button class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div></div>
        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>

