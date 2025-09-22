<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de Stage</title>
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
            border-bottom: 3px solid #7c3aed;
        }
        
        .company-info {
            margin-bottom: 30px;
            background: #faf5ff;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #7c3aed;
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
            color: #6b21a8;
            margin-bottom: 10px;
        }
        
        .attestation-title {
            font-size: 24px;
            font-weight: bold;
            color: #6b21a8;
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
        
        .student-info {
            background: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0ea5e9;
        }
        
        .internship-info {
            background: #fef3c7;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
        
        .evaluation {
            background: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #22c55e;
        }
        
        .highlight {
            font-weight: bold;
            color: #6b21a8;
        }
        
        .signatures {
            width: 100%;
            margin-top: 60px;
            page-break-inside: avoid;
            text-align: center;
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
        
        .skills-list {
            list-style-type: none;
            padding-left: 0;
        }
        
        .skills-list li {
            padding: 5px 0;
            border-bottom: 1px dotted #ddd;
        }
        
        .skills-list li:before {
            content: "✓ ";
            color: #22c55e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header" >
        <div class="company-info">
            <table style="width: 100%; border-collapse: collapse;">
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
        <h1 class="attestation-title">Attestation de Stage</h1>
    </div>

    <div class="content">
        <p>Je soussigné(e), <span class="highlight">{{ $directeur_rh }}</span>, Directeur des Ressources Humaines de <span class="highlight">{{ $entreprise }}</span>, atteste que :</p>

        <div class="student-info">
            <p><strong>{{ $civilite }} {{ $nom }} {{ $prenom }}</strong></p>
            <p>Étudiant(e) en <span class="highlight">{{ $formation ?? 'Non renseigné' }}</span></p>
            <p>Établissement : <span class="highlight">{{ $etablissement ?? 'Non renseigné' }}</span></p>
            <p>Niveau d'études : <span class="highlight">{{ $niveau_etudes ?? 'Non renseigné' }}</span></p>
        </div>

        <p>A effectué un stage dans notre entreprise dans les conditions suivantes :</p>

        <div class="internship-info">
            <p><strong>Informations du stage :</strong></p>
            <p>Période : Du <span class="highlight">{{ $date_debut_stage }}</span> au <span class="highlight">{{ $date_fin_stage }}</span></p>
            <p>Durée : <span class="highlight">{{ $duree_stage ?? 'Non renseigné' }}</span></p>
            <p>Service/Département : <span class="highlight">{{ $departement }}</span></p>
            <p>Maître de stage : <span class="highlight">{{ $maitre_stage ?? $hr_director_name ?? $directeur_rh }}</span></p>
            <p>Missions principales : <span class="highlight">{{ $missions_stage ?? 'Missions variées selon les besoins du service' }}</span></p>
        </div>

        <div class="evaluation">
            <p><strong>Évaluation du stage :</strong></p>
            <p>Le/La stagiaire a fait preuve de <span class="highlight">sérieux, de motivation et d'adaptabilité</span> tout au long de son stage.</p>
            
            @if(isset($competences_acquises) && $competences_acquises)
                <p><strong>Compétences développées :</strong></p>
                <ul class="skills-list">
                    @foreach(explode(',', $competences_acquises) as $competence)
                        <li>{{ trim($competence) }}</li>
                    @endforeach
                </ul>
            @endif
            
            <p>Appréciation générale : <span class="highlight">{{ $appreciation ?? 'Très satisfaisant' }}</span></p>
        </div>

        <p><strong>{{ $nom_complet }}</strong> a effectué un stage dans notre entreprise 
        @if($date_debut)du {{ $date_debut }}@endif @if($date_fin)au {{ $date_fin }}@endif 
        en qualité de <strong>{{ $poste }}</strong>.</p>

        <p>Durant cette période, le/la stagiaire a fait preuve de sérieux et de compétences 
        dans l'accomplissement de ses missions au sein du département <strong>{{ $departement }}</strong>.</p>

        <p>Cette attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.</p>

        <p style="margin-top: 40px;">Fait le <strong>{{ $date_actuelle }}</strong></p>
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