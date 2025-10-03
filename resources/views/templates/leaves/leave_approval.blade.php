<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorisation de Congé</title>
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
            padding-bottom: 10px;
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
        
        .document-title {
            font-size: 24px;
            font-weight: bold;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 10px 0;
        }

        .doc-date-number {
            margin-bottom: 20px;
        }
        
        .document-number {
            font-size: 11px;
            color: #666;
        }
        
        .content {
            margin: 20px 0;
            text-align: justify;
        }
        
        .employee-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #0ea5e9;
        }
        
        .leave-details {
            background: #fefce8;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #eab308;
        }
        
        .approval-section {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #22c55e;
        }
        
        .highlight {
            font-weight: bold;
            color: #047857;
        }
        
        .signatures {
            width: 100%;
            margin-top: 20px;
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
        
        .status-approved {
            color: #22c55e;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: bold;
            color: #374151;
        }
        
        .info-value {
            color: #047857;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-table td:first-child {
            font-weight: bold;
            color: #374151;
            width: 40%;
        }
        
        .info-table td:last-child {
            color: #047857;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
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

    <table class="doc-date-number" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td>
                <div class="document-number">
                    N° {{ $numero_demande }}
                </div>
            </td>
            <td>
                <div class="date-location">
                    {{ $ville_entreprise }}, le {{ $date_generation }}
                </div>
            </td>
        </tr>
    </table>

    <div class="header header-border">
        <h1 class="document-title">Autorisation de Congé</h1>
    </div>

    <div class="content">
        <p>Je soussigné(e), <span class="highlight">{{ $hr_director_name ?? $directeur_rh }}</span>, Directeur des Ressources Humaines de <span class="highlight">{{ $entreprise }}</span>, atteste par la présente avoir approuvé la demande de congé suivante :</p>

        <div class="employee-info">
            <h3 style="margin-top: 0; color: #0ea5e9;">Informations du demandeur</h3>
            <table class="info-table">
                <tr>
                    <td>Nom et Prénom :</td>
                    <td>{{ $civilite }} {{ $nom_complet }}</td>
                </tr>
                <tr>
                    <td>Poste :</td>
                    <td>{{ $poste }}</td>
                </tr>
                <tr>
                    <td>Département :</td>
                    <td>{{ $departement }}</td>
                </tr>
                <tr>
                    <td>Email :</td>
                    <td>{{ $email }}</td>
                </tr>
                @if($matricule)
                <tr>
                    <td>Matricule :</td>
                    <td>{{ $matricule }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="leave-details">
            <h3 style="margin-top: 0; color: #eab308;">Détails de la demande de congé</h3>
            <table class="info-table">
                <tr>
                    <td>Type de congé :</td>
                    <td>{{ $type_conge }}</td>
                </tr>
                <tr>
                    <td>Date de début :</td>
                    <td>{{ $date_debut }}</td>
                </tr>
                <tr>
                    <td>Date de fin :</td>
                    <td>{{ $date_fin }}</td>
                </tr>
                <tr>
                    <td>Nombre de jours :</td>
                    <td>{{ $duree_jours }} jour(s)</td>
                </tr>
                <tr>
                    <td>Date de soumission :</td>
                    <td>{{ $date_soumission }}</td>
                </tr>
                @if($motif)
                <tr>
                    <td>Motif :</td>
                    <td>{{ $motif }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="approval-section">
            <h3 style="margin-top: 0; color: #22c55e;">Validation</h3>
            <table class="info-table">
                <tr>
                    <td>Statut :</td>
                    <td><span class="status-approved">{{ $statut }}</span></td>
                </tr>
                <tr>
                    <td>Approuvé par :</td>
                    <td>{{ $approuve_par }}</td>
                </tr>
                <tr>
                    <td>Date d'approbation :</td>
                    <td>{{ $date_approbation }}</td>
                </tr>
                @if($commentaire_approbation)
                <tr>
                    <td>Commentaire :</td>
                    <td>{{ $commentaire_approbation }}</td>
                </tr>
                @endif
            </table>
        </div>

        <p>Cette autorisation de congé est délivrée pour servir et valoir ce que de droit. L'employé(e) est autorisé(e) à s'absenter durant la période mentionnée ci-dessus.</p>

        <p><strong>Important :</strong> Cette autorisation doit être présentée en cas de contrôle et conservée dans le dossier personnel de l'employé(e).</p>

        <p style="margin-top: 30px;">Fait le <strong>{{ $date_generation }}</strong></p>
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