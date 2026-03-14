@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Modifier le département</h3></div>
            <div class="card"><div class="card-body">
                <form method="POST" action="{{ route('recteur.departements.update', $departement) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Faculté</label>
                            <select name="faculte_id" class="form-select" required>
                                @foreach($facultes as $f)
                                    <option value="{{ $f->id }}" {{ $departement->faculte_id == $f->id ? 'selected' : '' }}>{{ $f->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input name="nom" class="form-control" value="{{ $departement->nom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code</label>
                            <input name="code" class="form-control" value="{{ $departement->code }}">
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a class="btn btn-secondary" href="{{ route('recteur.departements.index') }}">Annuler</a>
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

