<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de Travail</title>
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
            padding-bottom: 15px;
        }
        .header-border {
            border-bottom: 2px solid #2563eb;
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
        
        .work-details {
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
                            <div>N° d'enregistrement : {{ $siret }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="attestation-number">
        N° {{ $numero_certificat ?? 'CERT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}
    </div>

    <div class="date-location">
        {{ $ville_entreprise ?? 'Ville' }}, le {{ $date_actuelle ?? date('d/m/Y') }}
    </div>

    <div class="header header-border">
        <h1 class="attestation-title">Certificat de Travail</h1>
    </div>

    <div class="content">
        <div class="employee-info">
            <h2>Informations de l'Employé</h2>
            <table>
                <tr>
                    <td><strong>Nom complet:</strong></td>
                    <td>{{ $nom ?? 'NOM COMPLET' }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $email ?? 'email@example.com' }}</td>
                </tr>
                <tr>
                    <td><strong>Département:</strong></td>
                    <td>{{ $departement ?? 'Département' }}</td>
                </tr>
                <tr>
                    <td><strong>Poste:</strong></td>
                    <td>{{ $poste ?? 'Poste occupé' }}</td>
                </tr>
                <tr>
                    <td><strong>Date d'embauche:</strong></td>
                    <td>{{ $date_embauche ?? 'Date d\'embauche' }}</td>
                </tr>
                <tr>
                    <td><strong>Date de fin de contrat:</strong></td>
                    <td>{{ $date_fin_contrat ?? 'Date de fin de contrat' }}</td>
                </tr>
            </table>
        </div>

        <p>A été employé(e) dans notre entreprise en qualité de <strong class="highlight">{{ $poste ?? 'Poste occupé' }}</strong> 
        du <strong>{{ $date_embauche ?? 'JJ/MM/AAAA' }}</strong> au <strong>{{ $date_fin_contrat ?? 'JJ/MM/AAAA' }}</strong>.</p>

        <div class="employment-details">
            <h2>Détails de l'Emploi</h2>
            <table>
                <tr>
                     <td><strong>Type de contrat:</strong></td>
                     <td>{{ $type_contrat ?? 'Type de contrat' }}</td>
                 </tr>
                 <tr>
                     <td><strong>Durée du contrat:</strong></td>
                     <td>{{ $duree_contrat ?? 'Durée du contrat' }}</td>
                 </tr>
                 <tr>
                     <td><strong>Motif de fin de contrat:</strong></td>
                     <td>{{ $motif_fin ?? 'Motif de fin de contrat' }}</td>
                 </tr>
                 <tr>
                     <td><strong>Salaire final:</strong></td>
                     <td>{{ $salaire_final ?? 'Salaire final' }}</td>
                 </tr>
            </table>
        </div>

        <div class="appreciation">
            <p>{{ $appreciation ?? 'L\'employé(e) a fait preuve de professionnalisme et de compétence durant toute la durée de son contrat.' }}</p>
        </div>

        <div class="legal-mention">
            <p><em>Ce certificat est délivré pour servir et valoir ce que de droit.</em></p>
        </div>

        <div class="observations">
            <h3>Observations particulières :</h3>
            <p>{{ $observations ?? 'Aucune observation particulière.' }}</p>
        </div>
    </div>

    <div class="signatures">
        <table style="width: 100%; margin-top: 50px;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <!-- Espace pour signature employé si nécessaire -->
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    @if($signature_drh ?? false)
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $signature_drh))) }}" alt="Signature DRH" style="max-height: 100px; margin-bottom: 10px;">
                    @endif
                    <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto 5px;"></div>
                    <div style="font-weight: bold;">{{ $hr_director_name ?? 'Nom du Directeur RH' }}</div>
                    <div>{{ $hr_director_title ?? 'Directeur des Ressources Humaines' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Document généré automatiquement le {{ $date_generation }} - {{ $entreprise }}
    </div>

   

</body>
</html>