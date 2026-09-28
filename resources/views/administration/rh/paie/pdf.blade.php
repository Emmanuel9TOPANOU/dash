<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">

    <style>
        /* ---- Global ---- */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 110px;
            margin-right: 14px;
        }

        .company-info {
            font-size: 11px;
            line-height: 1.25;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            margin: 10px 0 20px 0;
            font-size: 18px;
        }

        .section-title {
            margin-top: 22px;
            margin-bottom: 6px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* ---- Table ---- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th, td {
            border: 1px solid #000;
            padding: 7px;
            font-size: 12px;
        }

        th {
            background: #f3f3f3;
            text-align: left;
            font-weight: bold;
        }

        .right { text-align: right; }
        .center { text-align: center; }

        /* ---- Footer ---- */
        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>

<body>

    {{-- ======= EN-TÊTE ENTREPRISE ======= --}}
    <div class="header">
            <img src="{{ asset('images/logo.png') }}">


        <div class="company-info">
            <div style="font-size:18px;font-weight:700;color:#f59e0b;">
                {{ $company['name'] ?? 'Nom Entreprise' }}
            </div>
            <div>{{ $company['tagline'] ?? '' }}</div>
            <div>Adresse : {{ $company['address'] ?? '' }}</div>
            <div>Tél : {{ $company['phone'] ?? '' }} — Email : {{ $company['email'] ?? '' }}</div>
            <div>RCCM : {{ $company['rccm'] ?? '' }}</div>
        </div>
    </div>

    {{-- ====== TITRE ====== --}}
    <h1>FICHE DE PAIE INDIVIDUELLE</h1>

    {{-- ====== INFORMATIONS EMPLOYÉ ====== --}}
    <h3 class="section-title">Informations de l’employé</h3>

    <table>
        <tr>
            <th style="width:35%;">Nom & Prénom</th>
            <td>{{ mb_strtoupper($employee->nom) }} {{ ucfirst($employee->prenom) }}</td>
        </tr>
        <tr>
            <th>Matricule</th>
            <td>{{ $employee->matricule }}</td>
        </tr>
        <tr>
            <th>Service</th>
            <td>{{ $employee->service }}</td>
        </tr>
        <tr>
            <th>Période</th>
            <td>{{ $periode }}</td>
        </tr>
    </table>

    {{-- ====== REMUNERATION ====== --}}
    <h3 class="section-title">Rémunération</h3>

    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th class="right">Montant (FCFA)</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Salaire brut</td>
                <td class="right">{{ number_format($salaire_brut, 0, ',', ' ') }}</td>
            </tr>

            <tr>
                <td>Avance / Acompte</td>
                <td class="right">{{ number_format($avance, 0, ',', ' ') }}</td>
            </tr>

            <tr>
                <td><strong>Net à payer</strong></td>
                <td class="right" style="font-weight:bold;">
                    {{ number_format($net, 0, ',', ' ') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ====== PIED PAGE ====== --}}
    <div class="footer">
        {{ $company['name'] ?? '' }} — RCCM : {{ $company['rccm'] ?? '' }}  
        | Tel : {{ $company['phone'] ?? '' }} — Email : {{ $company['email'] ?? '' }}
    </div>

</body>
</html>
