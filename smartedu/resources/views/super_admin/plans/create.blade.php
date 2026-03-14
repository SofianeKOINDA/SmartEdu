@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Créer un plan</h3></div>
            <div class="card"><div class="card-body">
                <form method="POST" action="{{ route('super_admin.plans.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nom</label><input name="nom" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Prix mensuel</label><input name="prix_mensuel" type="number" step="0.01" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Max étudiants</label><input name="max_etudiants" type="number" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Max enseignants</label><input name="max_enseignants" type="number" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4"></textarea></div>
                        <div class="col-md-4"><label class="form-label">Actif</label><select name="actif" class="form-select"><option value="1" selected>Oui</option><option value="0">Non</option></select></div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a class="btn btn-secondary" href="{{ route('super_admin.plans.index') }}">Annuler</a>
                        <button class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div></div>
        </div>
    </div>
</div>
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>

