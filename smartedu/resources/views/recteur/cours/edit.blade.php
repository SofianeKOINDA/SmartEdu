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
                        <h3 class="page-title">Modifier cours</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('recteur.cours.update', $cours) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">UE</label>
                                <select name="ue_id" class="form-select" required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($ues as $ue)
                                        <option value="{{ $ue->id }}" {{ old('ue_id', $cours->ue_id) == $ue->id ? 'selected' : '' }}>
                                            {{ $ue->nom }} {{ $ue->code ? '(' . $ue->code . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Enseignant (optionnel)</label>
                                <select name="enseignant_id" class="form-select">
                                    <option value="">— Aucun —</option>
                                    @foreach($enseignants as $ens)
                                        <option value="{{ $ens->id }}" {{ old('enseignant_id', $cours->enseignant_id) == $ens->id ? 'selected' : '' }}>
                                            {{ $ens->user->prenom ?? '' }} {{ $ens->user->nom ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Intitulé</label>
                                <input name="intitule" class="form-control" value="{{ old('intitule', $cours->intitule) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Code</label>
                                <input name="code" class="form-control" value="{{ old('code', $cours->code) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Coefficient</label>
                                <input name="coefficient" type="number" step="0.01" class="form-control" value="{{ old('coefficient', $cours->coefficient) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Volume horaire</label>
                                <input name="volume_horaire" type="number" class="form-control" value="{{ old('volume_horaire', $cours->volume_horaire) }}" min="0" required>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('recteur.cours.index') }}" class="btn btn-secondary">Annuler</a>
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
