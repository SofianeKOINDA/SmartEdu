@include("sections.enseignant.head")
<body>
<div class="main-wrapper">
    @include("sections.enseignant.menuHaut")
    @include("sections.enseignant.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Évaluations — {{ $cours->intitule }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.cours.index') }}">Mes cours</a></li>
                            <li class="breadcrumb-item active">Évaluations</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAjoutEval">
                            <i class="fas fa-plus me-1"></i> Nouvelle évaluation
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Intitulé</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th class="text-center">Coefficient</th>
                                    <th class="text-center">Notes saisies</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($evaluations as $eval)
                                    <tr>
                                        <td>{{ $eval->intitule }}</td>
                                        <td><span class="badge bg-secondary">{{ $eval->type ?? '—' }}</span></td>
                                        <td>{{ $eval->date ? \Carbon\Carbon::parse($eval->date)->format('d/m/Y') : '—' }}</td>
                                        <td class="text-center">{{ $eval->coefficient ?? 1 }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('enseignant.notes.index', $eval) }}"
                                               class="badge bg-info text-decoration-none">
                                                {{ $eval->notes->count() }} note(s)
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditEval{{ $eval->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('enseignant.evaluations.destroy', $eval) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Supprimer cette évaluation ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                            Aucune évaluation. Créez-en une !
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ajout --}}
<div class="modal fade" id="modalAjoutEval" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.evaluations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="cours_id" value="{{ $cours->id }}">
            <input type="hidden" name="tenant_id" value="{{ auth()->user()->tenant_id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle évaluation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Intitulé <span class="text-danger">*</span></label>
                        <input type="text" name="intitule" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="devoir">Devoir</option>
                            <option value="examen">Examen</option>
                            <option value="tp">TP</option>
                            <option value="quiz">Quiz</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coefficient</label>
                        <input type="number" name="coefficient" class="form-control" value="1" min="1" max="10">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modals Edit --}}
@foreach($evaluations as $eval)
<div class="modal fade" id="modalEditEval{{ $eval->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('enseignant.evaluations.update', $eval) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'évaluation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Intitulé</label>
                        <input type="text" name="intitule" class="form-control" value="{{ $eval->intitule }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            @foreach(['devoir','examen','tp','quiz'] as $t)
                                <option value="{{ $t }}" {{ $eval->type === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $eval->date }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coefficient</label>
                        <input type="number" name="coefficient" class="form-control" value="{{ $eval->coefficient ?? 1 }}" min="1" max="10">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
