<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Bienvenue, {{ auth()->user()->prenom }} !</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">Dashboard Enseignant</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Cartes statistiques -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Mes Cours</h6>
                                <h3><a href="{{ route('enseignant.cours') }}" class="text-dark">{{ $cours->count() }}</a></h3>
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
                                <h6>Mes Classes</h6>
                                <h3><a href="{{ route('enseignant.classes') }}" class="text-dark">{{ $classes->count() }}</a></h3>
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
                                <h6>Mes Étudiants</h6>
                                <h3><a href="{{ route('enseignant.etudiants') }}" class="text-dark">{{ $etudiants->count() }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-01.svg') }}" alt="">
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
                                <h6>Évaluations</h6>
                                <h3><a href="{{ route('enseignant.evaluations') }}" class="text-dark">{{ $evaluations->count() }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/teacher-icon-03.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Évaluations à venir -->
            <div class="col-12 col-xl-8">
                <div class="card comman-shadow">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Évaluations à venir</h5>
                        <a href="{{ route('enseignant.evaluations') }}" class="btn btn-sm btn-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center table-borderless mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Cours</th>
                                        <th>Titre</th>
                                        <th>Type</th>
                                        <th>Date limite</th>
                                        <th>Coeff.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($evaluations->where('date_limite', '>=', now())->take(5) as $eval)
                                    <tr>
                                        <td>{{ $eval->cours->titre ?? '—' }}</td>
                                        <td>{{ $eval->titre }}</td>
                                        <td><span class="badge bg-secondary">{{ $eval->type }}</span></td>
                                        <td>
                                            @php $diff = now()->diffInDays($eval->date_limite, false); @endphp
                                            @if($diff <= 3)
                                                <span class="badge bg-danger">{{ $eval->date_limite->format('d/m/Y') }}</span>
                                            @elseif($diff <= 7)
                                                <span class="badge bg-warning text-dark">{{ $eval->date_limite->format('d/m/Y') }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $eval->date_limite->format('d/m/Y') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $eval->coefficient }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted">Aucune évaluation à venir.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mes Cours -->
            <div class="col-12 col-xl-4">
                <div class="card comman-shadow">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Mes Cours</h5>
                        <a href="{{ route('enseignant.cours') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @forelse($cours->take(6) as $c)
                            <li class="mb-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-book me-2 text-primary"></i>
                                    {{ $c->titre }}
                                </div>
                                <span class="badge bg-info text-dark">{{ $c->evaluations_count }} éval.</span>
                            </li>
                            @empty
                            <li class="text-muted">Aucun cours assigné.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes récentes & Présences récentes -->
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card comman-shadow">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Notes récentes</h5>
                        <a href="{{ route('enseignant.notes') }}" class="btn btn-sm btn-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center table-borderless mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Évaluation</th>
                                        <th class="text-center">Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notesRecentes->take(5) as $note)
                                    <tr>
                                        <td>{{ $note->etudiant->user->prenom ?? '—' }} {{ $note->etudiant->user->nom ?? '' }}</td>
                                        <td>{{ $note->evaluation->titre ?? '—' }}</td>
                                        <td class="text-center">
                                            @if($note->valeur >= 10)
                                                <span class="badge bg-success">{{ $note->valeur }}/20</span>
                                            @else
                                                <span class="badge bg-danger">{{ $note->valeur }}/20</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center text-muted">Aucune note saisie.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card comman-shadow">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Présences récentes</h5>
                        <a href="{{ route('enseignant.presences') }}" class="btn btn-sm btn-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <ul class="activity-feed mb-0">
                            @forelse($presencesRecentes->take(6) as $presence)
                            <li class="feed-item">
                                <div class="feed-date">{{ $presence->date ? \Carbon\Carbon::parse($presence->date)->format('d/m') : '—' }}</div>
                                <span class="feed-text">
                                    <strong>{{ $presence->etudiant->user->prenom ?? '—' }} {{ $presence->etudiant->user->nom ?? '' }}</strong>
                                    — {{ $presence->cours->titre ?? '—' }}
                                    @if($presence->statut === 'present')
                                        <span class="badge bg-success ms-1">Présent</span>
                                    @elseif($presence->statut === 'absent')
                                        <span class="badge bg-danger ms-1">Absent</span>
                                    @else
                                        <span class="badge bg-warning text-dark ms-1">{{ ucfirst($presence->statut) }}</span>
                                    @endif
                                </span>
                            </li>
                            @empty
                            <li class="text-muted">Aucune présence saisie.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer>
        <p>Copyright &copy; {{ date('Y') }} SmartEdu.</p>
    </footer>
</div>
