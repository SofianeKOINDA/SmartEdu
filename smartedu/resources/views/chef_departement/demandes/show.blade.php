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
                        <h3 class="page-title">Traiter la demande #{{ $demande->id }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('chef_departement.demandes.index') }}">Demandes</a></li>
                            <li class="breadcrumb-item active">Détail</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        @if($demande->statut === 'traitee')
                            <a class="btn btn-outline-success" href="{{ route('chef_departement.demandes.download', $demande) }}">
                                <i class="fas fa-download me-1"></i> Télécharger
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

            <div class="card mb-3">
                <div class="card-body">
                    <div><strong>Étudiant :</strong> {{ $demande->etudiant?->user?->prenom ?? '' }} {{ $demande->etudiant?->user?->nom ?? '' }}</div>
                    <div><strong>Type :</strong> {{ $demande->type }}</div>
                    <div><strong>Motif :</strong> {{ $demande->motif ?? '—' }}</div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('chef_departement.demandes.update', $demande) }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Statut</label>
                                <select name="statut" class="form-select" required>
                                    @foreach(['en_attente','en_cours','traitee','rejetee','annulee'] as $s)
                                        <option value="{{ $s }}" {{ old('statut', $demande->statut) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Réponse / contenu du document</label>
                                <textarea name="reponse" rows="6" class="form-control">{{ old('reponse', $demande->reponse) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('chef_departement.demandes.index') }}" class="btn btn-secondary">Retour</a>
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

