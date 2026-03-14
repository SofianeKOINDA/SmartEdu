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
                        <h3 class="page-title">Bonjour, {{ auth()->user()->prenom }} 👋</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Statistiques --}}
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Mes cours</h6>
                                    <h3 class="text-primary">{{ $nbCours }}</h3>
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
                                    <h6>Moyenne générale</h6>
                                    <h3 class="{{ $moyenneGenerale >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ $moyenneGenerale !== null ? number_format($moyenneGenerale, 2) . '/20' : '—' }}
                                    </h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ asset('templates/assets/img/icons/dash-icon-02.svg') }}" alt="">
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
                                    <h3 class="{{ ($tauxPresence ?? 0) >= 75 ? 'text-success' : 'text-danger' }}">
                                        {{ $tauxPresence !== null ? $tauxPresence . '%' : '—' }}
                                    </h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ asset('templates/assets/img/icons/dash-icon-03.svg') }}" alt="">
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
                                    <h6>Prochaine échéance</h6>
                                    @if($prochaineEcheance)
                                    <h3 class="{{ $prochaineEcheance->statut === 'retard' ? 'text-danger' : 'text-warning' }}">
                                        {{ number_format($prochaineEcheance->montant, 0, ',', ' ') }} F
                                    </h3>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($prochaineEcheance->date_limite)->format('d/m/Y') }}</small>
                                    @else
                                    <h3 class="text-success">À jour ✓</h3>
                                    @endif
                                </div>
                                <div class="db-icon">
                                    <img src="{{ asset('templates/assets/img/icons/dash-icon-04.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Prochaine séance --}}
                <div class="col-md-6 d-flex">
                    <div class="card comman-shadow flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-clock me-2 text-primary"></i>Prochaine séance</h5>
                        </div>
                        <div class="card-body">
                            @if($prochaineSeance)
                            <p class="mb-1"><strong>{{ $prochaineSeance->cours->intitule ?? '—' }}</strong></p>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ ucfirst($prochaineSeance->jour) }}
                                {{ substr($prochaineSeance->heure_debut, 0, 5) }} – {{ substr($prochaineSeance->heure_fin, 0, 5) }}
                            </p>
                            @if($prochaineSeance->salle)
                            <p class="mb-0 text-muted"><i class="fas fa-map-marker-alt me-1"></i>Salle {{ $prochaineSeance->salle }}</p>
                            @endif
                            <span class="badge bg-secondary mt-2">{{ strtoupper($prochaineSeance->type) }}</span>
                            @else
                            <p class="text-muted mb-0">Aucune séance planifiée.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Dernières notes --}}
                <div class="col-md-6 d-flex">
                    <div class="card comman-shadow flex-fill">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fas fa-star me-2 text-warning"></i>Dernières notes</h5>
                            <a href="{{ route('etudiant.notes.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                        </div>
                        <div class="card-body p-0">
                            @if($dernieresNotes->isEmpty())
                            <p class="text-muted p-3 mb-0">Aucune note reçue.</p>
                            @else
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <tbody>
                                        @foreach($dernieresNotes as $note)
                                        <tr>
                                            <td>{{ $note->evaluation->intitule ?? '—' }}</td>
                                            <td class="text-muted small">{{ $note->evaluation->cours->intitule ?? '' }}</td>
                                            <td class="fw-bold {{ $note->valeur >= 10 ? 'text-success' : 'text-danger' }}">
                                                {{ $note->valeur }}/{{ $note->evaluation->note_max ?? 20 }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
