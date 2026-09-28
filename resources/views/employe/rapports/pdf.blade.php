<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport Mensuel - {{ $employee->prenom }} {{ $employee->nom }}</title>
    <style>
        @page {
            margin: 50px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #334155;
            line-height: 1.5;
        }

        /* En-tête */
        .header {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: -1px;
        }

        .company-name {
            color: #d97706;
        }

        /* Ambre */

        .report-title {
            text-align: right;
            float: right;
        }

        .report-title h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1e293b;
        }

        .report-period {
            color: #64748b;
            font-weight: bold;
        }

        .employee-info {
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
        }

        .employee-info td {
            border: none;
            padding: 4px 0;
        }

        .label {
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            font-size: 9px;
            width: 100px;
        }

        /* Sections */
        h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 4px solid #d97706;
            padding-left: 10px;
            margin-top: 25px;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 10px 8px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        /* Badges de statut */
        .status {
            font-size: 9px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .status-present {
            background: #dcfce7;
            color: #166534;
        }

        .status-absent {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="report-title">
            <h1>Rapport d'Activité</h1>
            <div class="report-period">
                {{ \Carbon\Carbon::createFromDate($year, $month)->locale('fr')->translatedFormat('F Y') }}
            </div>
        </div>
        <div class="logo">ELVIREX<span class="company-name"> RH</span></div>
        <div style="clear: both;"></div>
    </div>

    <div class="employee-info">
        <table style="width: 100%;">
            <tr>
                <td class="label">Collaborateur</td>
                <td style="font-weight: bold; font-size: 13px;">{{ $employee->prenom }} {{ $employee->nom }}</td>
                <td class="label">Matricule</td>
                <td style="font-weight: bold;">{{ $employee->matricule }}</td>
            </tr>
            <tr>
                <td class="label">Poste / Rôle</td>
                <td>{{ ucfirst($employee->role) }}</td>
                <td class="label">Généré le</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <h3>I. Registre des Présences</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $a)
                <tr>
                    <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($a->date)->translatedFormat('d M Y') }}</td>
                    <td>{{ $a->heure_arrivee ?? '--:--' }}</td>
                    <td>{{ $a->heure_depart ?? '--:--' }}</td>
                    <td>
                        <span class="status {{ $a->statut == 'présent' ? 'status-present' : 'status-absent' }}">
                            {{ $a->statut }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>II. Suivi des Absences</h3>
    <table>
        <thead>
            <tr>
                <th>Période</th>
                <th>Motif</th>
                <th>État du dossier</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absences as $ab)
                <tr>
                    <td>Du {{ \Carbon\Carbon::parse($ab->date_debut)->format('d/m/y') }} au
                        {{ \Carbon\Carbon::parse($ab->date_fin)->format('d/m/y') }}</td>
                    <td>{{ $ab->motif }}</td>
                    <td><span class="status status-pending">{{ $ab->statut }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #94a3b8; font-style: italic;">Aucune absence
                        signalée sur cette période.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>III. Réalisations & Tâches</h3>
    <table>
        <thead>
            <tr>
                <th>Libellé de la mission</th>
                <th>Échéance</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $t)
                <tr>
                    <td style="width: 60%;">{{ $t->description }}</td>
                    <td>{{ $t->date_limite ? \Carbon\Carbon::parse($t->date_limite)->format('d/m/Y') : '—' }}</td>
                    <td><span class="status">{{ $t->statut }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Document généré numériquement par la plateforme ELVIREX RH - Direction des Ressources Humaines
    </div>

</body>

</html>
