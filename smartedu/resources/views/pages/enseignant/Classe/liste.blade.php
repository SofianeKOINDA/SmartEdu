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
                        <h3 class="page-title">Mes Classes</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Classes</li>
                        </ul>
                    </div>
                </div>
            </div>

            @forelse($classes as $classe)
            <div class="card comman-shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-school me-2 text-primary"></i>{{ $classe->nom }}
                    </h5>
                    <span class="badge bg-primary">{{ $classe->etudiants->count() }} étudiant(s)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classe->etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->matricule }}</td>
                                    <td>{{ $etudiant->user->nom }}</td>
                                    <td>{{ $etudiant->user->prenom }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-muted">Aucun étudiant dans cette classe.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">Aucune classe assignée.</div>
            @endforelse

        </div>
    </div>
</div>

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
