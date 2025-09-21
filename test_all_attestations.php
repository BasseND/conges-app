<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttestationRequest;
use App\Models\AttestationType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

try {
    echo "=== Test de tous les types d'attestations ===\n\n";
    
    $user = User::first();
    if (!$user) {
        echo "✗ Aucun utilisateur trouvé\n";
        exit(1);
    }
    
    $controller = new \App\Http\Controllers\HrAttestationController();
    $reflection = new ReflectionClass($controller);
    $generatePdfMethod = $reflection->getMethod('generatePdf');
    $generatePdfMethod->setAccessible(true);
    
    $attestationTypes = AttestationType::all();
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($attestationTypes as $type) {
        echo "--- Test: {$type->name} ({$type->template_file}) ---\n";
        
        try {
            // Données spécifiques selon le type
            $customData = [];
            
            if ($type->template_file === 'attestation_stage') {
                $customData = [
                    'formation' => 'Master en Informatique',
                    'etablissement' => 'Université de Test',
                    'niveau_etudes' => 'Bac+5',
                    'maitre_stage' => 'Jean Dupont',
                    'missions_stage' => 'Développement web',
                    'competences_acquises' => 'Laravel, Vue.js',
                    'appreciation' => 'Excellent'
                ];
            } elseif ($type->template_file === 'solde_tout_compte') {
                $customData = [
                    'motif_fin_contrat' => 'Démission',
                    'salaire_final' => '3500',
                    'indemnite_cp' => '500',
                    'cotisations_sociales' => '200'
                ];
            }
            
            $attestation = AttestationRequest::create([
                'user_id' => $user->id,
                'attestation_type_id' => $type->id,
                'document_number' => 'TEST-' . strtoupper($type->template_file) . '-' . time(),
                'status' => 'pending',
                'start_date' => now()->subMonths(6),
                'end_date' => now()->subDays(1),
                'custom_data' => $customData,
                'requested_by' => 1,
                'generated_by' => 1,
                'notes' => 'Test automatique'
            ]);
            
            // Tester la génération PDF
            $generatePdfMethod->invoke($controller, $attestation);
            
            $attestation->refresh();
            if ($attestation->pdf_path && Storage::exists($attestation->pdf_path)) {
                echo "✓ PDF généré avec succès\n";
                echo "  - Fichier: {$attestation->pdf_path}\n";
                echo "  - Taille: " . Storage::size($attestation->pdf_path) . " bytes\n";
                $successCount++;
                
                // Nettoyer
                Storage::delete($attestation->pdf_path);
            } else {
                echo "✗ Fichier PDF non trouvé\n";
                $errorCount++;
            }
            
            $attestation->delete();
            
        } catch (Exception $e) {
            echo "✗ Erreur: " . $e->getMessage() . "\n";
            $errorCount++;
            
            // Nettoyer en cas d'erreur
            if (isset($attestation)) {
                if ($attestation->pdf_path) {
                    Storage::delete($attestation->pdf_path);
                }
                $attestation->delete();
            }
        }
        
        echo "\n";
    }
    
    echo "=== Résumé des tests ===\n";
    echo "✓ Succès: {$successCount}\n";
    echo "✗ Erreurs: {$errorCount}\n";
    echo "Total: " . ($successCount + $errorCount) . "\n";
    
    if ($errorCount === 0) {
        echo "\n🎉 Tous les tests sont passés avec succès !\n";
    } else {
        echo "\n⚠️  Certains tests ont échoué.\n";
    }
    
} catch (Exception $e) {
    echo "✗ Erreur générale: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}