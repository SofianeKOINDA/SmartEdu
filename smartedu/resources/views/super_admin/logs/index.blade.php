@include("sections.super_admin.head")
<body>
<div class="main-wrapper">
    @include("sections.super_admin.menuHaut")
    @include("sections.super_admin.menuGauche")
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header"><h3 class="page-title">Logs & activité</h3></div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Date</th><th>Description</th><th>Log</th><th>Causer</th></tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $l)
                                    <tr>
                                        <td class="text-muted">{{ $l->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $l->description }}</td>
                                        <td>{{ $l->log_name ?? 'default' }}</td>
                                        <td class="text-muted">{{ $l->causer_id ? ($l->causer_type . '#' . $l->causer_id) : '—' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun log.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">{{ $logs->links() }}</div>
        </div>
    </div>
</div>
@include("sections.super_admin.profilModal")
@include("sections.super_admin.script")
</body>
</html>

