@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Comptes utilisateurs</h3></div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Université</th><th class="text-end">Actions</th></tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                    <tr>
                                        <td>{{ $u->prenom ?? '' }} {{ $u->nom ?? '' }}</td>
                                        <td class="text-muted">{{ $u->email }}</td>
                                        <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                                        <td>{{ $u->tenant->nom ?? '—' }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('super_admin.users.desactiver', $u) }}" method="POST" class="d-inline">
                                                @csrf @method('PUT')
                                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Désactiver ce compte ?')">Désactiver</button>
                                            </form>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pwd{{ $u->id }}">MDP</button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="pwd{{ $u->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form class="modal-content" method="POST" action="{{ route('super_admin.users.password', $u) }}">
                                                @csrf @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Réinitialiser mot de passe</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">{{ $users->links() }}</div>
        </div>
    </div>
</div>
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>

