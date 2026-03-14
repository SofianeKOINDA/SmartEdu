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
                        <h3 class="page-title">Modifier étudiant</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('recteur.etudiants.index') }}">Étudiants</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('recteur.etudiants.update', $etudiant) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input name="prenom" class="form-control" value="{{ old('prenom', $etudiant->user->prenom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom', $etudiant->user->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $etudiant->user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Promotion</label>
                                <select name="promotion_id" class="form-select" required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($promotions as $p)
                                        <option value="{{ $p->id }}" {{ old('promotion_id', $etudiant->promotion_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nom }} (N{{ $p->niveau }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro étudiant (optionnel)</label>
                                <input name="numero_etudiant" class="form-control" value="{{ old('numero_etudiant', $etudiant->numero_etudiant) }}">
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('recteur.etudiants.index') }}" class="btn btn-secondary">Annuler</a>
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
