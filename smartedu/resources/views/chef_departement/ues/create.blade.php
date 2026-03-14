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
                        <h3 class="page-title">Créer une UE</h3>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('chef_departement.ues.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Semestre</label>
                                <select name="semestre_id" class="form-select" required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($semestres as $s)
                                        <option value="{{ $s->id }}" {{ old('semestre_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nom }} ({{ $s->numero }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input name="nom" class="form-control" value="{{ old('nom') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Code</label>
                                <input name="code" class="form-control" value="{{ old('code') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Coefficient</label>
                                <input name="coefficient" type="number" step="0.01" class="form-control" value="{{ old('coefficient', 1) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Crédits</label>
                                <input name="credit" type="number" class="form-control" value="{{ old('credit', 0) }}" required>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('chef_departement.ues.index') }}" class="btn btn-secondary">Annuler</a>
                            <button class="btn btn-primary">Créer</button>
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

