<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Document</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 12px; }
        .muted { color: #666; }
        .box { border: 1px solid #ddd; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="title">
        {{ match($demande->type) {
            'attestation' => 'Attestation de scolarité',
            'releve_notes' => 'Relevé de notes',
            'certificat' => 'Certificat de présence',
            default => 'Document'
        } }}
    </div>

    <div class="muted">Demande #{{ $demande->id }} — générée le {{ $demande->created_at->format('d/m/Y') }}</div>

    @if($demande->motif)
        <div class="box">
            <strong>Motif</strong><br>
            {{ $demande->motif }}
        </div>
    @endif

    <div class="box">
        <strong>Réponse</strong><br>
        {{ $demande->reponse ?? 'Document généré par l’administration.' }}
    </div>
</body>
</html>
