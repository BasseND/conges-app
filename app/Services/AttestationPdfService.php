<?php

namespace App\Services;

use App\Models\AttestationRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttestationPdfService
{
    /**
     * Générer le PDF d'une attestation
     */
    public function generatePdf(AttestationRequest $attestationRequest): string
    {
        $user = $attestationRequest->user;
        $attestationType = $attestationRequest->attestationType;
        
        // Générer le HTML à partir du template
        $html = $this->generateHtmlFromTemplate($attestationRequest);
        
        // Créer le PDF
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);
        
        // Générer le nom du fichier
        $filename = $this->generateFilename($attestationRequest);
        
        // Sauvegarder le PDF
        $pdfContent = $pdf->output();
        Storage::disk('public')->put('attestations/' . $filename, $pdfContent);
        
        return $filename;
    }
    
    /**
     * Générer le HTML à partir du template HTML
     */
    private function generateHtmlFromTemplate(AttestationRequest $attestationRequest): string
    {
        $user = $attestationRequest->user;
        $attestationType = $attestationRequest->attestationType;
        
        // Utiliser le template HTML si défini
        if ($attestationType->template_file) {
            return $this->renderHtmlTemplate($attestationType->template_file, $user, $attestationRequest);
        } else {
            // Générer un template par défaut si aucun template_file n'est défini
            throw new \Exception("Aucun template HTML défini pour ce type d'attestation.");
        }
    }
    
    /**
     * Rendre le template HTML avec les variables
     */
    private function renderHtmlTemplate(string $templateFile, User $user, AttestationRequest $attestationRequest): string
    {
        $variables = $this->getTemplateVariables($user, $attestationRequest);
        
        // Chemin du template
        $templatePath = "templates.attestations.{$templateFile}";
        
        // Vérifier si le template existe
        if (!view()->exists($templatePath)) {
            throw new \Exception("Le template {$templateFile} n'existe pas.");
        }
        
        // Rendre le template avec les variables
        return view($templatePath, $variables)->render();
    }
    
    /**
     * Récupérer le salaire brut depuis le contrat en vigueur
     */
    private function getSalaireFromActiveContract(User $user): string
    {
        $activeContract = \App\Models\Contract::getActiveForUser($user->id);
        
        if ($activeContract && $activeContract->salaire_brut) {
            return number_format($activeContract->salaire_brut, 0, ',', ' ');
        }
        
        // Fallback sur le salaire de l'utilisateur si pas de contrat actif
        return $user->salary ? number_format($user->salary, 0, ',', ' ') : 'Non renseigné';
    }

    /**
     * Obtenir toutes les variables pour les templates
     */
    private function getTemplateVariables(User $user, AttestationRequest $attestationRequest): array
    {
        // Récupérer les informations de l'entreprise depuis le modèle Company
        $company = \App\Models\Company::first(); // Récupère la première entreprise
        
        // Déterminer la civilité basée sur le genre
        $civilite = 'Monsieur/Madame'; // Valeur par défaut
        if ($user->gender) {
            $civilite = strtolower($user->gender) === 'female' || strtolower($user->gender) === 'f' || strtolower($user->gender) === 'femme' ? 'Madame' : 'Monsieur';
        }
        
        $variables = [
            'civilite' => $civilite,
            'nom' => strtoupper($user->last_name),
            'prenom' => ucfirst($user->first_name),
            'nom_complet' => $user->full_name,
            'email' => $user->email,
            'telephone' => $user->phone ?? 'Non renseigné',
            'poste' => $user->position ?? 'Non renseigné',
            'departement' => $user->department->name ?? 'Non renseigné',
            'manager' => $user->manager ? $user->manager->full_name : 'Non renseigné',
            'date_embauche' => $user->entry_date ? Carbon::parse($user->entry_date)->format('d/m/Y') : 'Non renseignée',
            'salaire' => $this->getSalaireFromActiveContract($user),
            'salaire_brut' => $this->getSalaireFromActiveContract($user),
            'date_debut' => $attestationRequest->start_date ? Carbon::parse($attestationRequest->start_date)->format('d/m/Y') : '',
            'date_fin' => $attestationRequest->end_date ? Carbon::parse($attestationRequest->end_date)->format('d/m/Y') : '',
            'periode' => $this->formatPeriod($attestationRequest),
            'date_actuelle' => Carbon::now()->format('d/m/Y'),
            'date_demande' => $attestationRequest->created_at->format('d/m/Y'),
            'date_generation' => Carbon::now()->format('d/m/Y à H:i'),
            'numero_attestation' => $this->generateAttestationNumber($attestationRequest),
            'entreprise' => $company ? $company->name : config('app.company_name', 'Nom de l\'entreprise'),
            'logo_entreprise' => $company ? $company->logo : null,
            'adresse_entreprise' => $company ? $company->address : config('app.company_address', 'Adresse de l\'entreprise'),
            'ville_entreprise' => $company ? $company->city : config('app.company_city', 'Ville'),
            'code_postal_entreprise' => $company ? $company->postal_code : config('app.company_postal_code', 'Code postal'),
            'siret' => $company ? $company->registration_number : config('app.company_siret', 'SIRET'),
            'directeur_rh' => $company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH'),
            'hr_director_name' => $company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH'),
            'hr_signature' => $company ? $company->hr_signature : null,
            'generateur' => $company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH'),
            
            // Variables spécifiques aux stages
            'date_debut_stage' => $attestationRequest->start_date ? Carbon::parse($attestationRequest->start_date)->format('d/m/Y') : '',
            'date_fin_stage' => $attestationRequest->end_date ? Carbon::parse($attestationRequest->end_date)->format('d/m/Y') : '',
            'duree_stage' => $this->calculateStageDuration($attestationRequest),
            'maitre_stage' => $attestationRequest->custom_data['maitre_stage'] ?? ($company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH')),
            'missions_stage' => $attestationRequest->custom_data['missions_stage'] ?? 'Missions variées selon les besoins du service',
            'formation' => $attestationRequest->custom_data['formation'] ?? 'Non renseigné',
            'etablissement' => $attestationRequest->custom_data['etablissement'] ?? 'Non renseigné',
            'niveau_etudes' => $attestationRequest->custom_data['niveau_etudes'] ?? 'Non renseigné',
            'competences_acquises' => $attestationRequest->custom_data['competences_acquises'] ?? '',
            'appreciation' => $attestationRequest->custom_data['appreciation'] ?? 'Très satisfaisant',
            
            // Variables spécifiques au travail
            'date_naissance' => $user->birth_date ? Carbon::parse($user->birth_date)->format('d/m/Y') : 'Non renseigné',
            'adresse_employe' => $user->address ?? 'Non renseigné',
            'date_fin_contrat' => $attestationRequest->custom_data['date_fin_contrat'] ?? null,
            'type_contrat' => $attestationRequest->custom_data['type_contrat'] ?? 'CDI',
            'motif_fin_contrat' => $attestationRequest->custom_data['motif_fin_contrat'] ?? null,
        ];
        
        // Ajouter les données personnalisées si elles existent
        if ($attestationRequest->custom_data) {
            foreach ($attestationRequest->custom_data as $key => $value) {
                if (!isset($variables[$key])) {
                    $variables[$key] = $value;
                }
            }
        }
        
        return $variables;
    }
    
    /**
     * Calculer la durée du stage
     */
    private function calculateStageDuration(AttestationRequest $attestationRequest): string
    {
        if ($attestationRequest->start_date && $attestationRequest->end_date) {
            $startDate = Carbon::parse($attestationRequest->start_date);
            $endDate = Carbon::parse($attestationRequest->end_date);
            $diffInDays = $startDate->diffInDays($endDate) + 1;
            
            if ($diffInDays < 7) {
                return $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '');
            } elseif ($diffInDays < 30) {
                $weeks = floor($diffInDays / 7);
                return $weeks . ' semaine' . ($weeks > 1 ? 's' : '');
            } else {
                $months = floor($diffInDays / 30);
                return $months . ' mois';
            }
        }
        
        return 'Non renseigné';
    }
    
    /**
     * Remplacer les variables dans le template (méthode conservée pour compatibilité)
     */
    public function replaceTemplateVariables(string $template, User $user, AttestationRequest $attestationRequest): string
    {
        // Récupérer les informations de l'entreprise depuis le modèle Company
        $company = \App\Models\Company::first();
        
        $variables = [
            '{nom}' => strtoupper($user->last_name),
            '{prenom}' => ucfirst($user->first_name),
            '{nom_complet}' => $user->full_name,
            '{email}' => $user->email,
            '{telephone}' => $user->phone ?? 'Non renseigné',
            '{poste}' => $user->position ?? 'Non renseigné',
            '{departement}' => $user->department->name ?? 'Non renseigné',
            '{manager}' => $user->manager ? $user->manager->full_name : 'Non renseigné',
            '{date_embauche}' => $user->hire_date ? Carbon::parse($user->hire_date)->format('d/m/Y') : 'Non renseignée',
            '{salaire}' => $user->salary ? number_format($user->salary, 0, ',', ' ') . ' €' : 'Non renseigné',
            '{salaire_brut}' => $user->salary ? number_format($user->salary, 0, ',', ' ') . ' €' : 'Non renseigné',
            '{date_debut}' => $attestationRequest->start_date ? Carbon::parse($attestationRequest->start_date)->format('d/m/Y') : '',
            '{date_fin}' => $attestationRequest->end_date ? Carbon::parse($attestationRequest->end_date)->format('d/m/Y') : '',
            '{periode}' => $this->formatPeriod($attestationRequest),
            '{date_actuelle}' => Carbon::now()->format('d/m/Y'),
            '{date_demande}' => $attestationRequest->created_at->format('d/m/Y'),
            '{numero_attestation}' => $this->generateAttestationNumber($attestationRequest),
            '{entreprise}' => $company ? $company->name : config('app.company_name', 'Nom de l\'entreprise'),
            '{adresse_entreprise}' => $company ? $company->address : config('app.company_address', 'Adresse de l\'entreprise'),
            '{ville_entreprise}' => $company ? $company->city : config('app.company_city', 'Ville'),
            '{code_postal_entreprise}' => $company ? $company->postal_code : config('app.company_postal_code', 'Code postal'),
            '{siret}' => $company ? $company->registration_number : config('app.company_siret', 'SIRET'),
            '{registration_number}' => $company ? $company->registration_number : config('app.company_siret', 'SIRET'),
            '{directeur_rh}' => $company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH'),
            '{hr_director_name}' => $company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH'),
            '{hr_signature}' => $company ? $company->hr_signature : null,
        ];
        
        // Ajouter les données personnalisées si elles existent
        if ($attestationRequest->custom_data) {
            foreach ($attestationRequest->custom_data as $key => $value) {
                $variables['{' . $key . '}'] = $value;
            }
        }
        
        return str_replace(array_keys($variables), array_values($variables), $template);
    }
    
    /**
     * Générer le template HTML complet
     */
    private function generateHtmlTemplate(string $content, AttestationRequest $attestationRequest): string
    {
        // Récupérer les informations de l'entreprise depuis le modèle Company
        $company = \App\Models\Company::first();
        
        $companyName = $company ? $company->name : config('app.company_name', 'Nom de l\'entreprise');
        $companyAddress = $company ? $company->address : config('app.company_address', 'Adresse de l\'entreprise');
        $companyCity = $company ? $company->city : config('app.company_city', 'Ville');
        $companyPostalCode = $company ? $company->postal_code : config('app.company_postal_code', 'Code postal');
        $attestationNumber = $this->generateAttestationNumber($attestationRequest);
        
        return '
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation - ' . $attestationRequest->attestationType->name . '</title>
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
            margin-bottom: 40px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .company-info {
            text-align: right;
            margin-bottom: 30px;
            font-size: 11px;
            color: #666;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 14px;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .attestation-title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #2563eb;
            margin: 30px 0;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .attestation-number {
            text-align: right;
            font-size: 10px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .content {
            text-align: justify;
            margin: 30px 0;
            line-height: 1.8;
        }
        
        .signature-section {
            margin-top: 60px;
            width: 100%;
            text-align: center;
        }
        
        .signature-left, .signature-right {
            width: 50%;
            vertical-align: top;
            display: inline-block;
        }
        
        .signature-right {
            text-align: right;
        }
        
        .signature-box {
            border: 1px solid #ddd;
            height: 80px;
            margin-top: 10px;
            background-color: #f9f9f9;
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
        
        .date {
            text-align: right;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .important {
            font-weight: bold;
            color: #2563eb;
        }
        
        .underline {
            text-decoration: underline;
        }
        
        .center {
            text-align: center;
        }
        
        .right {
            text-align: right;
        }
        
        .left {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="company-info">
        <div class="company-name">' . $companyName . '</div>
        <div>' . $companyAddress . '</div>
        <div>' . $companyPostalCode . ' ' . $companyCity . '</div>
    </div>
    
    <div class="attestation-number">
        N° ' . $attestationNumber . '
    </div>
    
    <div class="header">
        <div class="attestation-title">' . $attestationRequest->attestationType->name . '</div>
    </div>
    
    <div class="date">
        ' . $companyCity . ', le ' . Carbon::now()->format('d/m/Y') . '
    </div>
    
    <div class="content">
        ' . nl2br($content) . '
    </div>
    
    <div class="signature-section">
        <div class="signature-left">
            <div>L\'employé(e)</div>
            <div class="signature-box"></div>
            <div style="margin-top: 10px; font-size: 11px;">' . $attestationRequest->user->full_name . '</div>
        </div>
        <div class="signature-right">
            <div>L\'employeur</div>
            <div class="signature-box"></div>
            <div style="margin-top: 10px; font-size: 11px;">' . ($company ? $company->hr_director_name : config('app.hr_director_name', 'Directeur RH')) . '</div>
        </div>
    </div>
    
    <div class="footer">
        Document généré automatiquement le ' . Carbon::now()->format('d/m/Y à H:i') . ' - ' . $companyName . '
    </div>
</body>
</html>';
    }
    
    /**
     * Formater la période
     */
    private function formatPeriod(AttestationRequest $attestationRequest): string
    {
        if ($attestationRequest->start_date && $attestationRequest->end_date) {
            $startDate = Carbon::parse($attestationRequest->start_date);
            $endDate = Carbon::parse($attestationRequest->end_date);
            
            if ($startDate->isSameDay($endDate)) {
                return 'le ' . $startDate->format('d/m/Y');
            } else {
                return 'du ' . $startDate->format('d/m/Y') . ' au ' . $endDate->format('d/m/Y');
            }
        } elseif ($attestationRequest->start_date) {
            return 'à partir du ' . Carbon::parse($attestationRequest->start_date)->format('d/m/Y');
        } elseif ($attestationRequest->end_date) {
            return 'jusqu\'au ' . Carbon::parse($attestationRequest->end_date)->format('d/m/Y');
        }
        
        return '';
    }
    
    /**
     * Générer le numéro d'attestation
     */
    private function generateAttestationNumber(AttestationRequest $attestationRequest): string
    {
        $year = $attestationRequest->created_at->format('Y');
        $month = $attestationRequest->created_at->format('m');
        $typeCode = strtoupper(substr($attestationRequest->attestationType->type, 0, 3));
        
        return sprintf('ATT-%s-%s-%s-%04d', $year, $month, $typeCode, $attestationRequest->id);
    }
    
    /**
     * Générer le nom du fichier
     */
    private function generateFilename(AttestationRequest $attestationRequest): string
    {
        $user = $attestationRequest->user;
        $type = str_replace(' ', '_', $attestationRequest->attestationType->name);
        $date = Carbon::now()->format('Y-m-d');
        
        return sprintf(
            'attestation_%s_%s_%s_%d.pdf',
            strtolower($type),
            strtolower($user->last_name),
            $date,
            $attestationRequest->id
        );
    }
    
    /**
     * Télécharger le PDF
     */
    public function downloadPdf(AttestationRequest $attestationRequest): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filename = $attestationRequest->pdf_path;
        
        if (!$filename || !Storage::disk('public')->exists('attestations/' . $filename)) {
            // Générer le PDF s'il n'existe pas
            $filename = $this->generatePdf($attestationRequest);
            $attestationRequest->update(['pdf_path' => $filename]);
        }
        
        $filePath = storage_path('app/public/attestations/' . $filename);
        
        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    
    /**
     * Obtenir l'URL de prévisualisation du PDF
     */
    public function getPreviewUrl(AttestationRequest $attestationRequest): string
    {
        $filename = $attestationRequest->pdf_path;
        
        if (!$filename || !Storage::disk('public')->exists('attestations/' . $filename)) {
            return '';
        }
        
        return asset('storage/attestations/' . $filename);
    }
    
    /**
     * Supprimer le PDF
     */
    public function deletePdf(AttestationRequest $attestationRequest): bool
    {
        if ($attestationRequest->pdf_path && Storage::disk('public')->exists('attestations/' . $attestationRequest->pdf_path)) {
            return Storage::disk('public')->delete('attestations/' . $attestationRequest->pdf_path);
        }
        
        return true;
    }
    
    /**
     * Prévisualiser le contenu avant génération PDF
     */
    public function previewContent(AttestationRequest $attestationRequest): string
    {
        $user = $attestationRequest->user;
        $attestationType = $attestationRequest->attestationType;
        
        // Utiliser le système de templates HTML
        if ($attestationType->template_file) {
            return $this->renderHtmlTemplate($attestationType->template_file, $user, $attestationRequest);
        } else {
            throw new \Exception("Aucun template HTML défini pour ce type d'attestation.");
        }
    }
    
    /**
     * Valider le template
     */
    public function validateTemplate(string $template): array
    {
        $errors = [];
        
        // Vérifier que le template n'est pas vide
        if (empty(trim($template))) {
            $errors[] = 'Le template ne peut pas être vide';
        }
        
        // Vérifier les variables non fermées
        $openBraces = substr_count($template, '{');
        $closeBraces = substr_count($template, '}');
        
        if ($openBraces !== $closeBraces) {
            $errors[] = 'Les accolades ne sont pas équilibrées dans le template';
        }
        
        // Vérifier les variables inconnues
        preg_match_all('/\{([^}]+)\}/', $template, $matches);
        $knownVariables = [
            'nom', 'prenom', 'nom_complet', 'email', 'telephone', 'poste', 'departement', 'manager',
            'date_embauche', 'salaire', 'salaire_brut', 'date_debut', 'date_fin', 'periode',
            'date_actuelle', 'date_demande', 'numero_attestation', 'entreprise', 'adresse_entreprise',
            'ville_entreprise', 'code_postal_entreprise', 'siret', 'registration_number', 'directeur_rh'
        ];
        
        foreach ($matches[1] as $variable) {
            if (!in_array($variable, $knownVariables)) {
                $errors[] = "Variable inconnue: {$variable}";
            }
        }
        
        return $errors;
    }
}