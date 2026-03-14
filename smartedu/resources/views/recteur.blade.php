@include("sections.recteur.head")
<body>
<div class="main-wrapper">
    @include("sections.recteur.menuHaut")
    @include("sections.recteur.menuGauche")

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Tableau de bord</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card bg-comman w-100">
                        <div class="card-body">
                            <div class="db-widgets d-flex justify-content-between align-items-center">
                                <div class="db-info">
                                    <h6>Facultés</h6>
                                    <h3 class="text-primary">{{ $stats['facultes'] }}</h3>
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
                                    <h6>Enseignants</h6>
                                    <h3 class="text-success">{{ $stats['enseignants'] }}</h3>
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
                                    <h6>Étudiants actifs</h6>
                                    <h3 class="text-warning">{{ $stats['etudiants'] }}</h3>
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
                                    <h6>Tarifs configurés</h6>
                                    <h3 class="text-info">{{ $stats['tarifs'] }}</h3>
                                </div>
                                <div class="db-icon">
                                    <img src="{{ asset('templates/assets/img/icons/dash-icon-04.svg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include("sections.recteur.profilModal")
@include("sections.recteur.script")
</body>
</html>
