@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Créer une faculté</h3></div>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('recteur.facultes.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Code</label>
                                <input name="code" class="form-control" value="{{ old('code') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <a class="btn btn-secondary" href="{{ route('recteur.facultes.index') }}">Annuler</a>
                            <button class="btn btn-primary">Créer</button>
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

