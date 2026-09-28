<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport du personnel - Elvirex</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #f4f4f4; }
        h2 { color: #d4a017; text-align: center; margin-bottom: 10px; }
        .small { font-size: 10px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <h2>Rapport global du personnel - ELVIREX</h2>
    <p class="small">Généré le {{ now()->format('d/m/Y H:i') }}</p>

    @foreach($employees as $emp)
        <h3>{{ $emp->prenom }} {{ $emp->nom }} ({{ $emp->matricule }}) - {{ $emp->poste ?? '—' }}</h3>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure arrivée</th>
                    <th>Heure départ</th>
                    <th>Statut</th>
                    <th>Retard (min)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emp->attendances as $a)
                    <tr>
                        <td>{{ $a->date }}</td>
                        <td>{{ $a->heure_arrivee ?? '—' }}</td>
                        <td>{{ $a->heure_depart ?? '—' }}</td>
                        <td>{{ ucfirst($a->statut) }}</td>
                        <td>{{ $a->retard_minutes ?? '0' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" align="center">Aucune donnée de présence</td></tr>
                @endforelse
            </tbody>
        </table>

        <p><strong>Absences :</strong> {{ $emp->absences->count() }} | 
           <strong>Tâches :</strong> {{ $emp->tasks->count() }}</p>
        <hr style="margin: 20px 0;">
    @endforeach
</body>
</html>
