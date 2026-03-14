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
                        <h3 class="page-title">Mes résultats</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('etudiant.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mes résultats</li>
                        </ul>
                    </div>
                </div>
            </div>

            @forelse($deliberations as $delib)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center
                        {{ $delib->decision === 'admis' ? 'bg-success' : ($delib->decision === 'ajourné' ? 'bg-danger' : 'bg-warning') }} text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>
                            {{ $delib->semestre->libelle ?? 'Semestre' }}
                        </h5>
                        <div class="text-end">
                            <span class="badge bg-white text-dark fs-6 me-2">
                                Moyenne : {{ number_format($delib->moyenne, 2) }} / 20
                            </span>
                            <span class="badge bg-white
                                {{ $delib->decision === 'admis' ? 'text-success' : ($delib->decision === 'ajourné' ? 'text-danger' : 'text-warning') }} fw-bold">
                                {{ ucfirst($delib->decision) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h4 class="mb-0 {{ $delib->moyenne >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($delib->moyenne, 2) }}<small class="fs-6">/20</small>
                                    </h4>
                                    <p class="text-muted mb-0 small">Moyenne générale</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h4 class="mb-0">
                                        @php
                                            $mention = match(true) {
                                                $delib->moyenne >= 16 => 'Très bien',
                                                $delib->moyenne >= 14 => 'Bien',
                                                $delib->moyenne >= 12 => 'Assez bien',
                                                $delib->moyenne >= 10 => 'Passable',
                                                default               => '—',
                                            };
                                        @endphp
                                        {{ $mention }}
                                    </h4>
                                    <p class="text-muted mb-0 small">Mention</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h4 class="mb-0 {{ $delib->decision === 'admis' ? 'text-success' : 'text-danger' }}">
                                        {{ ucfirst($delib->decision) }}
                                    </h4>
                                    <p class="text-muted mb-0 small">Décision du jury</p>
                                </div>
                            </div>
                        </div>

                        @if($delib->observation)
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-comment me-2"></i>
                                <strong>Observation :</strong> {{ $delib->observation }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucun résultat de délibération disponible pour le moment.
                </div>
            @endforelse

        </div>
    </div>
</div>
@include("sections.etudiant.profilModal")
@include("sections.etudiant.script")
</body>
</html>
