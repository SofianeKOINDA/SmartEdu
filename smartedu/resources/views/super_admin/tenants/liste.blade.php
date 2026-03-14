@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Universités</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Universités</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenantModal">
                            <i class="fas fa-plus me-1"></i> Nouvelle université
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Slug</th>
                                            <th>Plan</th>
                                            <th>Email</th>
                                            <th>Statut</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tenants as $tenant)
                                        <tr>
                                            <td>{{ $tenant->id }}</td>
                                            <td><strong>{{ $tenant->nom }}</strong></td>
                                            <td><small class="text-muted">{{ $tenant->slug }}</small></td>
                                            <td><span class="badge bg-info">{{ $tenant->plan->nom ?? '—' }}</span></td>
                                            <td>{{ $tenant->email ?? '—' }}</td>
                                            <td>
                                                @if($tenant->actif)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTenant{{ $tenant->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteTenant{{ $tenant->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="7" class="text-center text-muted">Aucune université enregistrée.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $tenants->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ajouter --}}
<div class="modal fade" id="addTenantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle université</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('super_admin.tenants.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan <span class="text-danger">*</span></label>
                            <select name="plan_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="actif" value="1" checked id="actifAdd">
                                <label class="form-check-label" for="actifAdd">Actif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals Modifier / Supprimer --}}
@foreach($tenants as $tenant)
<div class="modal fade" id="editTenant{{ $tenant->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier — {{ $tenant->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('super_admin.tenants.update', $tenant) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control" value="{{ $tenant->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control" value="{{ $tenant->slug }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $tenant->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan <span class="text-danger">*</span></label>
                            <select name="plan_id" class="form-select" required>
                                @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $tenant->plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $tenant->telephone }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" value="{{ $tenant->adresse }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="actif" value="1"
                                    id="actif{{ $tenant->id }}" {{ $tenant->actif ? 'checked' : '' }}>
                                <label class="form-check-label" for="actif{{ $tenant->id }}">Actif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteTenant{{ $tenant->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Supprimer <strong>{{ $tenant->nom }}</strong> ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('super_admin.tenants.destroy', $tenant) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>
