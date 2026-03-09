<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Bienvenue, {{ auth()->user()->prenom }} !</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
                            <li class="breadcrumb-item active">Dashboard Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Cartes statistiques -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Étudiants</h6>
                                <h3><a href="{{ route('etudiants.index') }}" class="text-dark">{{ $stats['nb_etudiants'] }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-01.svg') }}" alt="Icône Dashboard">
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
                                <h6>Enseignants</h6>
                                <h3><a href="{{ route('enseignants.index') }}" class="text-dark">{{ $stats['nb_enseignants'] }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-02.svg') }}" alt="Icône Dashboard">
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
                                <h6>Cours</h6>
                                <h3><a href="{{ route('cours.index') }}" class="text-dark">{{ $stats['nb_cours'] }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-03.svg') }}" alt="Icône Dashboard">
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
                                <h6>Classes</h6>
                                <h3><a href="{{ route('classes.index') }}" class="text-dark">{{ $stats['nb_classes'] }}</a></h3>
                            </div>
                            <div class="db-icon">
                                <img src="{{ asset('templates/assets/img/icons/dash-icon-04.svg') }}" alt="Icône Dashboard">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Paiements validés -->
        <div class="row">
            <div class="col-xl-4 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Paiements validés</h6>
                                <h3><a href="{{ route('paiements.index') }}" class="text-dark">{{ number_format($stats['total_paiements'], 0, ',', ' ') }} FCFA</a></h3>
                            </div>
                            <div class="db-icon">
                                <i class="fas fa-coins fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des derniers étudiants -->
        <div class="row">
            <div class="col-12">
                <div class="card flex-fill comman-shadow">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Derniers Étudiants inscrits</h5>
                        <a href="{{ route('etudiants.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center table-borderless table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Nom Prénom</th>
                                        <th>Classe</th>
                                        <th>Date naissance</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($etudiants->take(5) as $etudiant)
                                    <tr>
                                        <td>{{ $etudiant->matricule }}</td>
                                        <td>{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}</td>
                                        <td>{{ $etudiant->classe->nom ?? '—' }}</td>
                                        <td>{{ $etudiant->date_naissance ? \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') : '—' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editEtudiantDash{{ $etudiant->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteEtudiantDash{{ $etudiant->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Modifier -->
                                    <div class="modal fade" id="editEtudiantDash{{ $etudiant->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier l'étudiant</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nom</label>
                                                            <input type="text" name="nom" class="form-control" value="{{ $etudiant->user->nom }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Prénom</label>
                                                            <input type="text" name="prenom" class="form-control" value="{{ $etudiant->user->prenom }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $etudiant->user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Matricule</label>
                                                            <input type="text" name="matricule" class="form-control" value="{{ $etudiant->matricule }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Date de naissance</label>
                                                            <input type="date" name="date_naissance" class="form-control" value="{{ $etudiant->date_naissance }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Classe</label>
                                                            <select name="classe_id" class="form-select">
                                                                @foreach($classes as $classe)
                                                                <option value="{{ $classe->id }}" {{ $etudiant->classe_id == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nouveau mot de passe (optionnel)</label>
                                                            <input type="password" name="password" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Confirmer le mot de passe</label>
                                                            <input type="password" name="password_confirmation" class="form-control">
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

                                    <!-- Modal Supprimer -->
                                    <div class="modal fade" id="deleteEtudiantDash{{ $etudiant->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmer la suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Supprimer <strong>{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}</strong> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucun étudiant enregistré.</td>
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
    <footer>
        <p>Copyright &copy; {{ date('Y') }} SmartEdu.</p>
    </footer>
</div>
