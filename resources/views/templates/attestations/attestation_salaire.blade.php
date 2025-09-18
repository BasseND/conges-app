<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de Salaire</title>
    <style>
        @page {
            margin: 1.5cm;
            @bottom-right {
                content: "Page " counter(page) " sur " counter(pages);
                font-size: 9px;
                color: #666;
            }
        }
        
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .company-info {
            margin-bottom: 15px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #2563eb;
        }
        
        .company-logo {
            flex-shrink: 0;
            margin-right: 15px;
            vertical-align: top;
        }
        
        .company-details {
            flex-grow: 1;
            vertical-align: top;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
        }
        
        .attestation-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0;
        }
        
        .attestation-number {
            font-size: 10px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .content {
            margin: 20px 0;
            text-align: justify;
        }
        
        .employee-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 3px solid #0ea5e9;
        }
        
        .salary-info {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 3px solid #22c55e;
        }
        
        .highlight {
            font-weight: bold;
            color: #1e40af;
        }
        
        .signatures {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            text-align: center;
            width: 40%;
            vertical-align: top;
            display: inline-block;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            height: 40px;
            margin: 15px 0 8px 0;
        }
        
        .footer {
            position: fixed;
            bottom: 0.8cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .date-location {
            text-align: right;
            margin-bottom: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    @if($logo_entreprise)
                        <td class="company-logo" style="width: 150px; vertical-align: top; padding-right: 15px;">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logo_entreprise))) }}" alt="Logo {{ $entreprise }}" style="max-height: 60px; max-width: 150px; display: block;">
                        </td>
                    @endif
                    <td class="company-details" style="vertical-align: top; text-align: {{ $logo_entreprise ? 'right' : 'left' }};">
                        <div class="company-name">{{ $entreprise }}</div>
                        <div>{{ $adresse_entreprise }}</div>
                        <div>{{ $code_postal_entreprise }} {{ $ville_entreprise }}</div>
                        @if($siret)
                            <div>SIRET : {{ $siret }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="attestation-number">
        N° {{ $numero_attestation }}
    </div>

    <div class="date-location">
        {{ $ville_entreprise }}, le {{ $date_actuelle }}
    </div>

    <div style="text-align: center;">
        <h1 class="attestation-title">Attestation de Salaire</h1>
    </div>

    <div class="content">
        <p>Je soussigné(e), <span class="highlight">{{ $directeur_rh }}</span>, Directeur des Ressources Humaines de <span class="highlight">{{ $entreprise }}</span>, certifie que :</p>

        <div class="employee-info">
            <p><strong>{{ $civilite }} {{ $nom }} {{ $prenom }}</strong></p>
            <p>Employé(e) en qualité de <span class="highlight">{{ $poste }}</span></p>
            <p>Département : <span class="highlight">{{ $departement }}</span></p>
            <p>Date d'embauche : <span class="highlight">{{ $date_embauche }}</span></p>
        </div>

        <div class="salary-info">
            <p>Perçoit un salaire mensuel brut de <span class="highlight">{{ $salaire }} {{ $globalCompanyCurrency }}</span></p>
            <p>Cette attestation est délivrée pour servir et valoir ce que de droit.</p>
        </div>

        <p>En foi de quoi, la présente attestation est établie en bonne et due forme.</p>
    </div>

    <div class="signatures">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="signature-box" style="text-align: center; vertical-align: top; padding: 0 20px;">
                    <div>L'employé(e)</div>
                    <div class="signature-line"></div>
                    <div>{{ $nom }} {{ $prenom }}</div>
                </td>
                <td class="signature-box" style="text-align: center; vertical-align: top; padding: 0 20px;">
                    <div>L'employeur</div>
                    <div class="signature-line"></div>
                    <div>{{ $directeur_rh }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement le {{ $date_generation }} - {{ $entreprise }}
    </div>
</body>
</html>