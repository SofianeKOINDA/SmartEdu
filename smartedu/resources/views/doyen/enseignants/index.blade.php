@include("sections.doyen.head")
<body>
<div class="main-wrapper">
    @include("sections.doyen.menuHaut")
    @include("sections.doyen.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header"><h3 class="page-title">Enseignants</h3></div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Département</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enseignants as $e)
                                    <tr>
                                        <td>{{ $e->user->prenom ?? '' }} {{ $e->user->nom ?? '' }}</td>
                                        <td>{{ $e->departement->nom ?? '—' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('doyen.enseignants.show', $e) }}">Détail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Aucun enseignant.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $enseignants->links() }}</div>
        </div>
    </div>
</div>
@include("sections.doyen.profilModal")
@include("sections.doyen.script")
</body>
</html>

