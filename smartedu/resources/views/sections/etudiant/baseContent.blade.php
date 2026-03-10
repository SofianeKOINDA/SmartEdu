<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- ===== Page Header ===== --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Bonjour, {{ auth()->user()->prenom }} !</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">Dashboard Étudiant</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- ===== Stats Cards ===== --}}
        @php
            $nbCours      = $etudiant->classe ? $etudiant->classe->cours->count() : 0;
            $nbNotes      = $notes->count();
            $nbEvals      = $evaluations->count();
            $nbPresences  = $presences->count();
            $nbPresent    = $presences->where('statut', 'present')->count();
            $tauxPresence = $nbPresences > 0 ? round(($nbPresent / $nbPresences) * 100) : 0;
        @endphp

        <div class="row">

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Mes Cours</h6>
                                <h3>{{ $nbCours }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/teacher-icon-01.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Mes Notes</h6>
                                <h3>{{ $nbNotes }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/teacher-icon-02.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Évaluations à venir</h6>
                                <h3>{{ $nbEvals }}</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/student-icon-01.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Taux de présence</h6>
                                <h3>{{ $tauxPresence }}%</h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/student-icon-02.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /.row stats --}}

        {{-- ===== Contenu Principal ===== --}}
        <div class="row">

            {{-- Colonne gauche (8/12) --}}
            <div class="col-12 col-xl-8">

                {{-- === Évaluations à venir === --}}
                <div class="card flex-fill comman-shadow" id="mes-evaluations">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>Évaluations à venir
                        </h5>
                        <span class="badge bg-primary">{{ $nbEvals }}</span>
                    </div>
                    <div class="card-body">
                        @forelse($evaluations as $eval)
                        <div class="feed-item d-flex align-items-center py-2 border-bottom">
                            <div class="dolor-activity flex-grow-1">
                                <span class="feed-text1">
                                    <strong>{{ $eval->titre }}</strong>
                                    <span class="badge bg-secondary ms-2">{{ $eval->type }}</span>
                                </span>
                                <ul class="teacher-date-list mt-1">
                                    <li><i class="fas fa-book me-1 text-muted"></i>{{ $eval->cours->titre ?? '—' }}</li>
                                    <li class="ms-3">|</li>
                                    <li class="ms-3"><i class="fas fa-calendar-alt me-1 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($eval->date_limite)->format('d/m/Y à H:i') }}
                                    </li>
                                    <li class="ms-3">|</li>
                                    <li class="ms-3"><i class="fas fa-weight me-1 text-muted"></i>Coeff. {{ $eval->coefficient }}</li>
                                </ul>
                            </div>
                            <div class="activity-btns ms-3">
                                @php $diff = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($eval->date_limite), false); @endphp
                                @if($diff <= 3)
                                    <span class="badge bg-danger">Dans {{ $diff }}j</span>
                                @elseif($diff <= 7)
                                    <span class="badge bg-warning text-dark">Dans {{ $diff }}j</span>
                                @else
                                    <span class="badge bg-success">Dans {{ $diff }}j</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3">Aucune évaluation à venir.</p>
                        @endforelse
                    </div>
                </div>

                {{-- === Mes Dernières Notes === --}}
                <div class="card flex-fill comman-shadow" id="mes-notes">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star me-2 text-warning"></i>Mes Dernières Notes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Évaluation</th>
                                        <th>Cours</th>
                                        <th class="text-center">Note</th>
                                        <th>Semestre</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notes->take(10) as $note)
                                    <tr>
                                        <td>{{ $note->evaluation->titre ?? '—' }}</td>
                                        <td>{{ $note->evaluation->cours->titre ?? '—' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $note->valeur >= 10 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                {{ number_format($note->valeur, 2) }}/20
                                            </span>
                                        </td>
                                        <td>{{ $note->semestre }}</td>
                                        <td class="text-muted">{{ $note->commentaire ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucune note enregistrée.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- === Historique des Présences === --}}
                <div class="card flex-fill comman-shadow" id="mes-presences">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check me-2 text-success"></i>Historique des Présences
                        </h5>
                        <span class="badge bg-success">{{ $tauxPresence }}% présent</span>
                    </div>
                    <div class="card-body">
                        <div class="teaching-card">
                            <ul class="activity-feed">
                                @forelse($presences->take(8) as $presence)
                                <li class="feed-item d-flex align-items-center">
                                    <div class="dolor-activity flex-grow-1">
                                        <span class="feed-text1">
                                            <strong>{{ $presence->cours->titre ?? '—' }}</strong>
                                        </span>
                                        <ul class="teacher-date-list">
                                            <li><i class="fas fa-calendar-alt me-2"></i>
                                                {{ \Carbon\Carbon::parse($presence->date)->format('d/m/Y') }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="activity-btns ms-auto {{ $presence->statut === 'present' ? 'complete' : '' }}">
                                        @if($presence->statut === 'present')
                                            <span class="badge bg-success px-3 py-2">Présent</span>
                                        @elseif($presence->statut === 'retard')
                                            <span class="badge bg-warning text-dark px-3 py-2">Retard</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">Absent</span>
                                        @endif
                                    </div>
                                </li>
                                @empty
                                <li class="text-muted text-center py-3">Aucune présence enregistrée.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>{{-- /.col gauche --}}

            {{-- Colonne droite (4/12) --}}
            <div class="col-12 col-xl-4 d-flex flex-column gap-3">

                {{-- === Mes Cours === --}}
                <div class="card comman-shadow" id="mes-cours">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-book-reader me-2 text-info"></i>Mes Cours
                        </h5>
                        @if($etudiant->classe)
                        <span class="badge bg-info">{{ $etudiant->classe->nom }}</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if($etudiant->classe && $etudiant->classe->cours->count() > 0)
                            @foreach($etudiant->classe->cours as $cours)
                            <div class="d-flex align-items-center px-3 py-2 border-bottom">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $cours->titre }}</h6>
                                    <small class="text-muted">
                                        {{ $cours->type }} —
                                        {{ $cours->enseignant->user->prenom ?? '' }} {{ $cours->enseignant->user->nom ?? '—' }}
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark">{{ $cours->evaluations_count ?? 0 }} éval.</span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center py-3 px-3">Aucun cours associé à votre classe.</p>
                        @endif
                    </div>
                </div>

                {{-- === Mes Paiements === --}}
                <div class="card comman-shadow" id="mes-paiements">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice-dollar me-2 text-success"></i>Mes Paiements
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="calendar-info">
                        @forelse($paiements->take(6) as $paiement)
                        <div class="calendar-details px-3 py-2">
                            <div class="calendar-box {{ $paiement->statut === 'valide' ? 'normal-bg' : ($paiement->statut === 'rejete' ? 'break-bg' : '') }}">
                                <div class="calandar-event-name">
                                    <h4>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</h4>
                                    <h5>{{ $paiement->type }} — {{ $paiement->methode }}</h5>
                                </div>
                                <div class="d-flex flex-column align-items-end">
                                    <span class="text-muted small">{{ \Carbon\Carbon::parse($paiement->date)->format('d/m/Y') }}</span>
                                    @if($paiement->statut === 'valide')
                                        <span class="badge bg-success mt-1">Validé</span>
                                    @elseif($paiement->statut === 'rejete')
                                        <span class="badge bg-danger mt-1">Rejeté</span>
                                    @else
                                        <span class="badge bg-warning text-dark mt-1">En attente</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 px-3">Aucun paiement enregistré.</p>
                        @endforelse
                    </div>
                </div>

            </div>{{-- /.col droite --}}

        </div>{{-- /.row principal --}}

    </div>{{-- /.content --}}

    <footer>
        <p>Copyright &copy; {{ date('Y') }} SmartEdu.</p>
    </footer>

</div>{{-- /.page-wrapper --}}

{{-- ===== Modal Modifier Profil ===== --}}
<div class="modal fade" id="profilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Modifier mon profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('etudiant.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control"
                            value="{{ auth()->user()->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom" class="form-control"
                            value="{{ auth()->user()->prenom }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo de profil</label>
                        <input type="file" name="photo_profil" class="form-control" accept="image/*">
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
