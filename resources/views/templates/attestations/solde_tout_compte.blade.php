<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solde de Tout Compte</title>
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
            font-size: 15px;
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
        
        .document-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0;
        }
        
        .document-number {
            font-size: 10px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .content {
            margin: 20px 0;
            text-align: justify;
        }
        
        .employee-section {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 3px solid #0ea5e9;
        }
        
        .employee-section h3 {
            margin-top: 0;
            color: #1e40af;
            font-size: 14px;
            font-weight: bold;
        }
        
        .contract-info {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 3px solid #22c55e;
        }
        
        .info-block {
            margin-bottom: 8px;
        }
        
        .info-block strong {
            color: #1e40af;
        }
        
        .highlight {
            font-weight: bold;
            color: #1e40af;
        }
        
        .date-location {
            text-align: right;
            margin-bottom: 15px;
            font-style: italic;
        }
        
        .financial-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11px;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .financial-table th {
            background-color: #1e40af;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .financial-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .financial-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .financial-table tr:hover {
            background-color: #f0f9ff;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .positive-amount {
            color: #22c55e;
        }
        
        .negative-amount {
            color: #ef4444;
        }
        
        .total-row {
            background-color: #1e40af !important;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        
        .total-row td {
            padding: 15px 8px;
        }
        
        .summary-section {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 3px solid #22c55e;
        }
        
        .summary-section h4 {
            margin-top: 0;
            color: #1e40af;
            font-size: 14px;
            font-weight: bold;
        }
        
        .payment-info {
            background: #fefce8;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border-left: 3px solid #eab308;
        }
        
        .payment-info h4 {
            margin-top: 0;
            color: #1e40af;
            font-size: 14px;
            font-weight: bold;
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
            height: 60px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }
        
        .signature-label {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }
        
        .date-location {
            text-align: right;
            margin: 25px 0;
            font-size: 11pt;
            font-weight: bold;
        }
        
        .footer {
            position: fixed;
            bottom: 0.8cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .legal-notice {
            background: #fef2f2;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 3px solid #ef4444;
            font-size: 10px;
        }
        
        .legal-notice p {
            margin: 0;
            color: #991b1b;
        }
        
        @media print {
            .no-print {
                display: none;
            }
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
                        <div class="company-name">{{ $entreprise ?? 'NOM DE L\'ENTREPRISE' }}</div>
                        <div>{{ $adresse_entreprise ?? 'Adresse de l\'entreprise' }}</div>
                        <div>{{ $code_postal_entreprise ?? '' }} {{ $ville_entreprise ?? '' }}</div>
                        @if($siret ?? 'SIRET de l\'entreprise')
                            <div>SIRET : {{ $siret ?? 'SIRET de l\'entreprise' }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="document-number">
        Document N° {{ $numero_solde ?? 'STC-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}
    </div>

    <div class="date-location">
        {{ $ville_entreprise ?? 'Lieu' }}, le {{ $date_actuelle ?? date('d/m/Y') }}
    </div>

    <div class="header header-border">
        <h1 class="document-title">Solde de Tout Compte</h1>
    </div>

    <div class="content">
        <p>Je soussigné(e), <span class="highlight">{{ $hr_director_name ?? $directeur_rh }}</span>, Directeur des Ressources Humaines de <span class="highlight">{{ $entreprise }}</span>, certifie que :</p>

        <div class="employee-section">
            <h3>Informations du salarié</h3>
            <p><strong>{{ $civilite }} {{ $nom }} {{ $prenom }}</strong></p>
            <p>Employé(e) en qualité de <span class="highlight">{{ $poste }}</span></p>
            <p>Date d'embauche : <span class="highlight">{{ $date_embauche }}</span></p>
            <p>Date de fin de contrat : <span class="highlight">{{ $date_fin_contrat }}</span></p>
            <p>Motif de fin de contrat : <span class="highlight">{{ $motif_fin_contrat }}</span></p>
        </div>

        <div class="contract-info">
            <h4 style="margin-top: 0; color: #1e40af; font-size: 14px; font-weight: bold;">Récapitulatif financier</h4>
            <p>Le présent solde de tout compte fait apparaître les éléments suivants :</p>
        </div>
    </div>

    <table class="financial-table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Période</th>
                <th>Base de calcul</th>
                <th>Montant (€)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Éléments de rémunération -->
            <tr>
                <td><strong>Salaire du mois</strong></td>
                <td>{{ $periode_salaire ?? date('m/Y') }}</td>
                <td>{{ $base_salaire ?? 'Salaire mensuel' }}</td>
                <td class="amount positive-amount">{{ $montant_salaire ?? '0,00' }}</td>
            </tr>
            
            @if(isset($heures_supplementaires) && $heures_supplementaires > 0)
            <tr>
                <td>Heures supplémentaires</td>
                <td>{{ $periode_hs ?? date('m/Y') }}</td>
                <td>{{ $heures_supplementaires ?? '0' }} heures</td>
                <td class="amount positive-amount">{{ $montant_hs ?? '0,00' }}</td>
            </tr>
            @endif
            
            @if(isset($prime_anciennete) && $prime_anciennete > 0)
            <tr>
                <td>Prime d'ancienneté</td>
                <td>{{ $periode_anciennete ?? date('m/Y') }}</td>
                <td>{{ $anciennete ?? '0' }} années</td>
                <td class="amount positive-amount">{{ $prime_anciennete ?? '0,00' }}</td>
            </tr>
            @endif
            
            <tr>
                <td><strong>Indemnité de congés payés</strong></td>
                <td>{{ $periode_cp ?? 'Période de référence' }}</td>
                <td>{{ $jours_cp ?? '0' }} jours</td>
                <td class="amount positive-amount">{{ $indemnite_cp ?? '0,00' }}</td>
            </tr>
            
            @if(isset($indemnite_preavis) && $indemnite_preavis > 0)
            <tr>
                <td>Indemnité de préavis</td>
                <td>{{ $periode_preavis ?? 'Période de préavis' }}</td>
                <td>{{ $duree_preavis ?? '0' }} jours</td>
                <td class="amount positive-amount">{{ $indemnite_preavis ?? '0,00' }}</td>
            </tr>
            @endif
            
            @if(isset($indemnite_licenciement) && $indemnite_licenciement > 0)
            <tr>
                <td>Indemnité de licenciement</td>
                <td>Ancienneté</td>
                <td>{{ $anciennete_calcul ?? 'Base de calcul' }}</td>
                <td class="amount positive-amount">{{ $indemnite_licenciement ?? '0,00' }}</td>
            </tr>
            @endif
            
            <!-- Déductions -->
            <tr>
                <td>Cotisations sociales salariales</td>
                <td>{{ $periode_cotisations ?? date('m/Y') }}</td>
                <td>{{ $taux_cotisations ?? '0' }}%</td>
                <td class="amount negative-amount">-{{ $cotisations_sociales ?? '0,00' }}</td>
            </tr>
            
            <tr>
                <td>Impôt sur le revenu (prélèvement à la source)</td>
                <td>{{ $periode_impot ?? date('m/Y') }}</td>
                <td>{{ $taux_impot ?? '0' }}%</td>
                <td class="amount negative-amount">-{{ $impot_revenu ?? '0,00' }}</td>
            </tr>
            
            @if(isset($avance_salaire) && $avance_salaire > 0)
            <tr>
                <td>Avance sur salaire</td>
                <td>{{ $periode_avance ?? 'Période' }}</td>
                <td>Remboursement</td>
                <td class="amount negative-amount">-{{ $avance_salaire ?? '0,00' }}</td>
            </tr>
            @endif
            
            @if(isset($autres_deductions) && $autres_deductions > 0)
            <tr>
                <td>{{ $libelle_autres_deductions ?? 'Autres déductions' }}</td>
                <td>{{ $periode_autres ?? 'Période' }}</td>
                <td>{{ $base_autres ?? 'Base' }}</td>
                <td class="amount negative-amount">-{{ $autres_deductions ?? '0,00' }}</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3"><strong>SOLDE NET À PAYER</strong></td>
                <td class="amount"><strong>{{ $solde_net ?? '0,00' }} €</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="summary-section">
        <h4>Récapitulatif des sommes versées</h4>
        <p><strong>Total des sommes brutes :</strong> {{ $total_brut ?? '0,00' }} €</p>
        <p><strong>Total des déductions :</strong> {{ $total_deductions ?? '0,00' }} €</p>
        <p><strong>Solde net à payer :</strong> <span style="font-size: 14pt; color: #27ae60;">{{ $solde_net ?? '0,00' }} €</span></p>
    </div>

    <div class="payment-info">
        <h4>Modalités de paiement</h4>
        <p><strong>Mode de paiement :</strong> {{ $mode_paiement ?? 'Virement bancaire' }}</p>
        <p><strong>Date de versement :</strong> {{ $date_paiement ?? date('d/m/Y') }}</p>
        @if(isset($reference_paiement))
        <p><strong>Référence :</strong> {{ $reference_paiement }}</p>
        @endif
    </div>

    <div class="legal-notice">
        <p><strong>Important :</strong> Ce solde de tout compte fait l'objet d'un reçu pour solde de tout compte 
        que le salarié peut signer. Ce reçu peut être dénoncé dans un délai de 6 mois à compter de sa signature 
        (Article L1234-20 du Code du travail).</p>
    </div>

    <div class="signatures">
        <div class="signature-box" style="float: left;">
            <div class="signature-line"></div>
            <div class="signature-label">
                Signature de l'employé(e)<br>
                (Bon pour accord et reçu)
            </div>
        </div>
        <div class="signature-box" style="float: right;">
            <div class="signature-line">
                @if(isset($hr_signature) && $hr_signature)
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $hr_signature))) }}" alt="Signature DRH" style="max-height: 80px; max-width: 200px;">
                @endif
            </div>
            <p style="margin: 0 0 10px 0; font-weight: bold;">
                {{ $hr_director_name ?? $generateur }}
            </p>
            <p style="margin: 0; font-size: 11px; color: #666;">
                Directeur des Ressources Humaines
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        Document généré automatiquement le {{ $date_generation }} - {{ $entreprise }}
    </div>
</body>
</html>