<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttestationRequest;
use App\Models\User;
use App\Models\AttestationType;
use Illuminate\Support\Facades\Log;

try {
    echo "=== Test de création d'attestation avec gestion d'erreur PDF ===\n";
    
    // Compter les attestations avant
    $countBefore = AttestationRequest::count();
    echo "Nombre d'attestations avant: {$countBefore}\n";
    
    // Récupérer un utilisateur et un type d'attestation
    $user = User::first();
    $attestationType = AttestationType::where('is_active', true)->first();
    
    if (!$user || !$attestationType) {
        echo "✗ Utilisateur ou type d'attestation non trouvé\n";
        exit(1);
    }
    
    echo "✓ Utilisateur trouvé: {$user->first_name} {$user->last_name}\n";
    echo "✓ Type d'attestation trouvé: {$attestationType->name}\n";
    
    // Simuler la création d'une attestation (comme dans le contrôleur)
    $customData = [];
    
    try {
        $attestation = AttestationRequest::create([
            'user_id' => $user->id,
            'attestation_type_id' => $attestationType->id,
            'document_number' => 'TEST-' . time(),
            'status' => 'pending',
            'custom_data' => $customData,
            'requested_by' => 1, // Simuler un utilisateur admin
            'generated_by' => 1,
            'notes' => 'Test de création'
        ]);
        
        echo "✓ Attestation créée avec ID: {$attestation->id}\n";
        
        // Tenter de générer le PDF (comme dans le contrôleur modifié)
        try {
            // Simuler la génération PDF qui va échouer
            throw new Exception('Erreur simulée de génération PDF');
            
        } catch (Exception $pdfError) {
            // Log l'erreur PDF mais continue
            echo "⚠ Erreur PDF capturée: {$pdfError->getMessage()}\n";
            $attestation->update([
                'status' => 'pending', 
                'notes' => ($attestation->notes ? $attestation->notes . '\n' : '') . 'Erreur PDF: ' . $pdfError->getMessage()
            ]);
            echo "✓ Attestation mise à jour avec l'erreur PDF\n";
        }
        
        // Vérifier que l'attestation existe toujours
        $attestationCheck = AttestationRequest::find($attestation->id);
        if ($attestationCheck) {
            echo "✓ Attestation confirmée en base de données\n";
            echo "  - Status: {$attestationCheck->status}\n";
            echo "  - Notes: {$attestationCheck->notes}\n";
        } else {
            echo "✗ Attestation non trouvée après création\n";
        }
        
    } catch (Exception $e) {
        echo "✗ Erreur lors de la création: {$e->getMessage()}\n";
        exit(1);
    }
    
    // Compter les attestations après
    $countAfter = AttestationRequest::count();
    echo "\nNombre d'attestations après: {$countAfter}\n";
    echo "Différence: " . ($countAfter - $countBefore) . "\n";
    
    if ($countAfter > $countBefore) {
        echo "✓ SUCCESS: L'attestation a été créée malgré l'erreur PDF\n";
    } else {
        echo "✗ ÉCHEC: Aucune nouvelle attestation créée\n";
    }
    
} catch (Exception $e) {
    echo "✗ Erreur générale: {$e->getMessage()}\n";
    echo "Trace: {$e->getTraceAsString()}\n";
}