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
                        <h3 class="page-title">Mon emploi du temps</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Emploi du temps</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card comman-shadow">
                <div class="card-body p-0">
                    @if($seances->isEmpty())
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>Aucune séance planifiée pour votre promotion.</p>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:80px">Horaire</th>
                                    @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                                    <th>{{ $j }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $heures = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
                                    $jours  = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                                @endphp
                                @foreach($heures as $h)
                                <tr>
                                    <td class="fw-bold text-muted small">{{ $h }}</td>
                                    @foreach($jours as $jour)
                                    @php
                                        $s = $seances->first(fn($x) => $x->jour === $jour && substr($x->heure_debut, 0, 5) === $h);
                                    @endphp
                                    <td class="{{ $s ? 'bg-primary bg-opacity-10' : '' }}">
                                        @if($s)
                                        <small class="d-block fw-bold text-primary">{{ $s->cours->titre ?? '?' }}</small>
                                        <small class="text-muted">{{ substr($s->heure_debut,0,5) }}–{{ substr($s->heure_fin,0,5) }}</small><br>
                                        <small class="badge bg-secondary">{{ strtoupper($s->type) }}</small>
                                        @if($s->salle)<small class="d-block text-muted">{{ $s->salle }}</small>@endif
                                        @endif
                                    </td>
                                    @endforeach
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

@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
