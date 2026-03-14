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
                        <h3 class="page-title">{{ $enseignant->user->prenom ?? '' }} {{ $enseignant->user->nom ?? '' }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.enseignants.index') }}">Enseignants</a></li>
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
                                <p>{{ $enseignant->user->prenom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <p>{{ $enseignant->user->nom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <p>{{ $enseignant->user->email ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Département</label>
                                <p>{{ $enseignant->departement->nom ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <p>{{ $enseignant->grade ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Spécialité</label>
                                <p>{{ $enseignant->specialite ?? '—' }}</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('recteur.enseignants.edit', $enseignant) }}" class="btn btn-primary">Modifier</a>
                                <a href="{{ route('recteur.enseignants.index') }}" class="btn btn-secondary">Retour</a>
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
