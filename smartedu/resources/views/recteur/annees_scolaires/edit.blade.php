@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Modifier l’année scolaire</h3></div>
            <div class="card"><div class="card-body">
                <form method="POST" action="{{ route('recteur.annees-scolaires.update', $annee) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Libellé</label>
                            <input name="libelle" class="form-control" value="{{ $annee->libelle }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date début</label>
                            <input type="date" name="date_debut" class="form-control" value="{{ $annee->date_debut?->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date fin</label>
                            <input type="date" name="date_fin" class="form-control" value="{{ $annee->date_fin?->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Courante</label>
                            <select name="courante" class="form-select">
                                <option value="0" {{ $annee->courante ? '' : 'selected' }}>Non</option>
                                <option value="1" {{ $annee->courante ? 'selected' : '' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a class="btn btn-secondary" href="{{ route('recteur.annees-scolaires.index') }}">Annuler</a>
                        <button class="btn btn-primary">Enregistrer</button>
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

