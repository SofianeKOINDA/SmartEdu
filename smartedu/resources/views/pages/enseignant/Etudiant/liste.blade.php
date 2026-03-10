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
                        <h3 class="page-title">Mes Étudiants</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes Étudiants</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Matricule</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Classe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($etudiants as $etudiant)
                                        <tr>
                                            <td>{{ $etudiant->matricule }}</td>
                                            <td>{{ $etudiant->user->nom }}</td>
                                            <td>{{ $etudiant->user->prenom }}</td>
                                            <td>{{ $etudiant->classe->nom ?? '—' }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center text-muted">Aucun étudiant.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include("sections.enseignant.profilModal")
@include("sections.enseignant.script")
</body>
</html>
