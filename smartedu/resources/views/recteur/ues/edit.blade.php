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
                        <h3 class="page-title">Modifier UE</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('recteur.ues.update', $ue) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Semestre</label>
                                <select name="semestre_id" class="form-select" required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($semestres as $s)
                                        <option value="{{ $s->id }}" {{ old('semestre_id', $ue->semestre_id) == $s->id ? 'selected' : '' }}>
                                            {{ $s->nom }} ({{ $s->numero }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom', $ue->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Code</label>
                                <input name="code" class="form-control" value="{{ old('code', $ue->code) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coefficient</label>
                                <input name="coefficient" type="number" step="0.01" class="form-control" value="{{ old('coefficient', $ue->coefficient) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Crédits</label>
                                <input name="credit" type="number" class="form-control" value="{{ old('credit', $ue->credit) }}" required>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('recteur.ues.index') }}" class="btn btn-secondary">Annuler</a>
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
