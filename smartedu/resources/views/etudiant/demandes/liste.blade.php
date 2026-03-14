@include("sections.etudiant.head")
<body>
<div class="main-wrapper">
    @include("sections.etudiant.menuHaut")
    @include("sections.etudiant.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Mes demandes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes demandes</li>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNouvelledemande">
                            <i class="fas fa-plus me-1"></i> Nouvelle demande
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
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Motif</th>
                                    <th>Date de demande</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($demandes as $demande)
                                    <tr>
                                        <td>
                                            @php
                                                $label = match($demande->type) {
                                                    'attestation'  => 'Attestation de scolarité',
                                                    'releve_notes' => 'Relevé de notes',
                                                    'certificat'   => 'Certificat de présence',
                                                    default        => $demande->type,
                                                };
                                            @endphp
                                            {{ $label }}
                                        </td>
                                        <td>{{ $demande->motif ?? '—' }}</td>
                                        <td>{{ $demande->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            @php
                                                $badge = match($demande->statut) {
                                                    'en_attente' => ['bg-warning text-dark', 'En attente'],
                                                    'en_cours'   => ['bg-info', 'En cours'],
                                                    'traitee'    => ['bg-success', 'Traitée'],
                                                    'rejetee'    => ['bg-danger', 'Rejetée'],
                                                    'annulee'    => ['bg-secondary', 'Annulée'],
                                                    default      => ['bg-secondary', $demande->statut],
                                                };
                                            @endphp
                                            <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($demande->statut === 'traitee')
                                                    <a href="{{ route('etudiant.demandes.download', $demande) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Télécharger
                                                    </a>
                                                @endif

                                                @if($demande->statut === 'en_attente')
                                                    <form action="{{ route('etudiant.demandes.destroy', $demande) }}" method="POST"
                                                          onsubmit="return confirm('Annuler cette demande ?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-times"></i> Annuler
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($demande->statut !== 'traitee' && $demande->statut !== 'en_attente')
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-envelope-open-text fa-2x mb-2 d-block"></i>
                                            Aucune demande pour le moment.
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

{{-- Modal Nouvelle demande --}}
<div class="modal fade" id="modalNouvelledemande" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('etudiant.demandes.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-envelope-open-text me-2"></i>Nouvelle demande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type de document <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            <option value="attestation" {{ old('type') == 'attestation' ? 'selected' : '' }}>Attestation de scolarité</option>
                            <option value="releve_notes" {{ old('type') == 'releve_notes' ? 'selected' : '' }}>Relevé de notes</option>
                            <option value="certificat" {{ old('type') == 'certificat' ? 'selected' : '' }}>Certificat de présence</option>
                            <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motif (optionnel)</label>
                        <textarea name="motif" class="form-control @error('motif') is-invalid @enderror"
                                  rows="3" placeholder="Précisez le motif de votre demande...">{{ old('motif') }}</textarea>
                        @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Soumettre
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
