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
                        <h3 class="page-title">{{ $etudiant->user->prenom ?? '' }} {{ $etudiant->user->nom ?? '' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.etudiants.index') }}">Étudiants</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <p>{{ $etudiant->user->prenom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <p>{{ $etudiant->user->nom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <p>{{ $etudiant->user->email ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Promotion</label>
                                <p>{{ $etudiant->promotion->nom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Numéro étudiant</label>
                                <p>{{ $etudiant->numero_etudiant ?? '—' }}</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('recteur.etudiants.edit', $etudiant) }}" class="btn btn-primary">Modifier</a>
                                <a href="{{ route('recteur.etudiants.index') }}" class="btn btn-secondary">Retour</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
