<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttestationRequest;
use App\Models\AttestationType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

try {
    echo "=== Test de génération PDF avec variables corrigées ===\n";
    
    // Récupérer une attestation de stage
    $attestationType = AttestationType::where('template_file', 'attestation_stage')->first();
    
    if (!$attestationType) {
        echo "✗ Type d'attestation de stage non trouvé\n";
        exit(1);
    }
    
    echo "✓ Type d'attestation trouvé: {$attestationType->name}\n";
    
    // Créer une attestation de test
    $user = User::first();
    if (!$user) {
        echo "✗ Aucun utilisateur trouvé\n";
        exit(1);
    }
    
    $attestation = AttestationRequest::create([
        'user_id' => $user->id,
        'attestation_type_id' => $attestationType->id,
        'document_number' => 'TEST-STAGE-' . time(),
        'status' => 'pending',
        'start_date' => now()->subMonths(3),
        'end_date' => now()->subDays(1),
        'custom_data' => [
            'formation' => 'Master en Informatique',
            'etablissement' => 'Université de Test',
            'niveau_etudes' => 'Bac+5',
            'maitre_stage' => 'Jean Dupont',
            'missions_stage' => 'Développement d\'applications web, Tests unitaires',
            'competences_acquises' => 'Laravel, Vue.js, Tests automatisés',
            'appreciation' => 'Excellent'
        ],
        'requested_by' => 1,
        'generated_by' => 1,
        'notes' => 'Test de génération PDF'
    ]);
    
    echo "✓ Attestation de test créée avec ID: {$attestation->id}\n";
    
    // Tester la génération PDF avec le contrôleur
    $controller = new \App\Http\Controllers\HrAttestationController();
    
    try {
        // Utiliser la méthode privée via reflection
        $reflection = new ReflectionClass($controller);
        $generatePdfMethod = $reflection->getMethod('generatePdf');
        $generatePdfMethod->setAccessible(true);
        
        $generatePdfMethod->invoke($controller, $attestation);
        
        echo "✓ PDF généré avec succès\n";
        
        // Vérifier que le fichier PDF existe
        $attestation->refresh();
        if ($attestation->pdf_path && Storage::exists($attestation->pdf_path)) {
            echo "✓ Fichier PDF sauvegardé: {$attestation->pdf_path}\n";
            echo "  - Taille: " . Storage::size($attestation->pdf_path) . " bytes\n";
        } else {
            echo "✗ Fichier PDF non trouvé\n";
        }
        
    } catch (Exception $pdfError) {
        echo "✗ Erreur lors de la génération PDF: " . $pdfError->getMessage() . "\n";
        echo "Trace: " . $pdfError->getTraceAsString() . "\n";
    }
    
    // Nettoyer - supprimer l'attestation de test
    if ($attestation->pdf_path) {
        Storage::delete($attestation->pdf_path);
    }
    $attestation->delete();
    echo "✓ Attestation de test supprimée\n";
    
} catch (Exception $e) {
    echo "✗ Erreur générale: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}