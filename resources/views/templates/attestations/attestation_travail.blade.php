<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de Travail</title>
    <style>
        @page {
            margin: 2cm;
            @bottom-right {
                content: "Page " counter(page) " sur " counter(pages);
                font-size: 10px;
                color: #666;
            }
        }
        
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header-border {
            border-bottom: 3px solid #059669;
        }
        
        .company-info {
            margin-bottom: 30px;
            background: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #059669;
        }
        
        .company-logo {
            flex-shrink: 0;
            margin-right: 20px;
            vertical-align: top;
        }
        
        .company-details {
            flex-grow: 1;
            vertical-align: top;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #047857;
            margin-bottom: 10px;
        }
        
        .attestation-title {
            font-size: 24px;
            font-weight: bold;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 30px 0;
        }
        
        .attestation-number {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .content {
            margin: 30px 0;
            text-align: justify;
        }
        
        .employee-info {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0ea5e9;
        }
        
        .work-period {
            background: #fefce8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #eab308;
        }
        
        .highlight {
            font-weight: bold;
            color: #047857;
        }
        
        .signatures {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            text-align: center;
            width: 45%;
            vertical-align: top;
            display: inline-block;
        }
        
        
        .footer {
            position: fixed;
            bottom: 1cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .date-location {
            text-align: right;
            margin-bottom: 30px;
            font-style: italic;
        }
        
        .official-stamp {
            text-align: center;
            margin: 40px 0;
            padding: 20px;
            border: 2px dashed #059669;
            background: #f0fdf4;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <tr>
                        @if($logo_entreprise && file_exists(storage_path('app/public/' . $logo_entreprise)))
                            <td class="company-logo" style="width: 150px; vertical-align: top; padding-right: 15px;">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logo_entreprise))) }}" alt="Logo {{ $entreprise }}" style="max-height: 60px; max-width: 150px; display: block;">
                            </td>
                        @endif
                        <td class="company-details" style="vertical-align: top; text-align: {{ $logo_entreprise ? 'right' : 'left' }};">
                            <div class="company-name">{{ $entreprise }}</div>
                            <div>{{ $adresse_entreprise }}</div>
                            <div>{{ $code_postal_entreprise }} {{ $ville_entreprise }}</div>
                            @if($siret)
                                <div>N° d'enregistrement : {{ $siret }}</div>
                            @endif
                        </td>
                    </tr>
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

    <div class="header header-border">
        <h1 class="attestation-title">Attestation de Travail</h1>
    </div>

    <div class="content">
        <p>Je soussigné(e), <span class="highlight">{{ $hr_director_name ?? $directeur_rh }}</span>, Directeur des Ressources Humaines de <span class="highlight">{{ $entreprise }}</span>, atteste par la présente que :</p>

        <div class="employee-info">
            <p><strong>{{ $civilite }} {{ $nom }} {{ $prenom }}</strong></p>
            <p>Né(e) le : <span class="highlight">{{ $date_naissance ?? 'Non renseigné' }}</span></p>
            <p>Demeurant : <span class="highlight">{{ $adresse_employe ?? 'Non renseigné' }}</span></p>
        </div>

        <p>A été employé(e) dans notre entreprise en qualité de <span class="highlight">{{ $poste }}</span> au sein du département <span class="highlight">{{ $departement }}</span>.</p>

        <div class="work-period">
            <p><strong>Période d'emploi :</strong></p>
            <p>Du <span class="highlight">{{ $date_embauche }}</span> au <span class="highlight">{{ $date_fin_contrat ?? 'En cours' }}</span></p>
            <p>Type de contrat : <span class="highlight">{{ $type_contrat ?? 'CDI' }}</span></p>
            @if($motif_fin_contrat)
                <p>Motif de fin de contrat : <span class="highlight">{{ $motif_fin_contrat }}</span></p>
            @endif
        </div>

        <p>Durant cette période, l'intéressé(e) s'est acquitté(e) de ses fonctions avec <span class="highlight">compétence et assiduité</span>.</p>

        <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>

        <div class="official-stamp">
            <p><strong>Cachet et signature de l'entreprise</strong></p>
        </div>
    </div>

    <div class="signatures">
        @if(isset($hr_signature) && $hr_signature && file_exists(storage_path('app/public/' . $hr_signature)))
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $hr_signature))) }}" alt="Signature DRH" style="max-height: 80px; max-width: 200px;">
            </div>
        @endif
        <p style="margin: 0 0 10px 0; font-weight: bold;">
            {{ $hr_director_name ?? $generateur }}
        </p>
        <p style="margin: 0; font-size: 11px; color: #666;">
            Directeur des Ressources Humaines
        </p>
    </div>

    <div class="footer">
        Document généré automatiquement le {{ $date_generation }} - {{ $entreprise }}
    </div>
</body>
</html>