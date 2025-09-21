<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttestationRequest;

try {
    echo "=== Vérification finale des attestations ===\n";
    
    // Compter toutes les attestations
    $totalCount = AttestationRequest::count();
    echo "Total des attestations: {$totalCount}\n";
    
    // Afficher les 5 dernières attestations
    $recentAttestations = AttestationRequest::with(['user', 'attestationType'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    echo "\n=== 5 dernières attestations ===\n";
    foreach ($recentAttestations as $attestation) {
        echo "ID: {$attestation->id}\n";
        echo "  - Utilisateur: {$attestation->user->first_name} {$attestation->user->last_name}\n";
        echo "  - Type: {$attestation->attestationType->name}\n";
        echo "  - Status: {$attestation->status}\n";
        echo "  - Numéro: {$attestation->document_number}\n";
        echo "  - Créé le: {$attestation->created_at}\n";
        if ($attestation->notes) {
            echo "  - Notes: {$attestation->notes}\n";
        }
        echo "  ---\n";
    }
    
    // Vérifier les attestations avec erreurs PDF
    $attestationsWithPdfErrors = AttestationRequest::where('notes', 'like', '%Erreur PDF%')->count();
    echo "\nAttestations avec erreurs PDF: {$attestationsWithPdfErrors}\n";
    
    // Vérifier les attestations en statut pending
    $pendingAttestations = AttestationRequest::where('status', 'pending')->count();
    echo "Attestations en attente: {$pendingAttestations}\n";
    
    // Vérifier les attestations générées
    $generatedAttestations = AttestationRequest::where('status', 'generated')->count();
    echo "Attestations générées: {$generatedAttestations}\n";
    
    echo "\n✓ Vérification terminée\n";
    
} catch (Exception $e) {
    echo "✗ Erreur: {$e->getMessage()}\n";
}