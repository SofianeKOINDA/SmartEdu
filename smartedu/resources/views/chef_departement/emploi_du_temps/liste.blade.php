@include("sections.chef_departement.head")
<body>
<div class="main-wrapper">
    @include("sections.chef_departement.menuHaut")
    @include("sections.chef_departement.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Emploi du temps</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Emploi du temps</li>
                        </ul>
                    </div>
                </div>
            </div>

            @foreach($promotions as $promotion)
            <div class="card comman-shadow mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2 text-primary"></i>{{ $promotion->nom }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:80px">Horaire</th>
                                    @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
                                    <th>{{ $jour }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $heures = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
                                    $jours  = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                                    $seancesPromo = $seancesParPromotion[$promotion->id] ?? collect();
                                @endphp
                                @foreach($heures as $h)
                                <tr>
                                    <td class="fw-bold text-muted small">{{ $h }}</td>
                                    @foreach($jours as $jour)
                                    @php
                                        $s = $seancesPromo->first(fn($x) => $x->jour === $jour && substr($x->heure_debut, 0, 5) === $h);
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
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@include("sections.chef_departement.profilModal")
@include("sections.chef_departement.script")
</body>
</html>
