<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Validator;
use App\Models\AttestationType;
use App\Models\User;

try {
    echo "=== Test de validation du formulaire ===\n";
    
    // Récupérer un utilisateur et un type d'attestation
    $user = User::first();
    $attestationType = AttestationType::where('status', 'active')->first();
    
    echo "✓ Utilisateur: {$user->first_name} {$user->last_name} (ID: {$user->id})\n";
    echo "✓ Type d'attestation: {$attestationType->name} (ID: {$attestationType->id})\n";
    
    // Simuler les données du formulaire comme elles viendraient du POST
    $requestData = [
        'user_id' => $user->id,
        'attestation_type_id' => $attestationType->id,
        'custom_data' => [],
        'start_date' => null,
        'end_date' => null,
        'notes' => 'Test de validation',
        'category' => 'hr_generated'
    ];
    
    echo "\n=== Données du formulaire ===\n";
    foreach ($requestData as $key => $value) {
        echo "- {$key}: " . (is_array($value) ? json_encode($value) : ($value ?? 'null')) . "\n";
    }
    
    // Tester la validation comme dans le contrôleur
    $validator = Validator::make($requestData, [
        'user_id' => 'required|exists:users,id',
        'attestation_type_id' => 'required|exists:attestation_types,id',
        'custom_data' => 'nullable|array',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'notes' => 'nullable|string|max:1000',
        'category' => 'required|in:hr_generated,employee_request'
    ]);
    
    echo "\n=== Résultat de la validation ===\n";
    if ($validator->fails()) {
        echo "✗ Validation échouée:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "  - {$error}\n";
        }
    } else {
        echo "✓ Validation réussie!\n";
    }
    
    // Vérifier que le type d'attestation est actif
    $attestationTypeCheck = AttestationType::active()->find($requestData['attestation_type_id']);
    if (!$attestationTypeCheck) {
        echo "✗ Type d'attestation non actif ou introuvable\n";
    } else {
        echo "✓ Type d'attestation actif confirmé\n";
        echo "  - Requires date range: " . ($attestationTypeCheck->requires_date_range ? 'Oui' : 'Non') . "\n";
        echo "  - Requires salary info: " . ($attestationTypeCheck->requires_salary_info ? 'Oui' : 'Non') . "\n";
    }
    
    // Vérifier les champs requis selon le type
    if ($attestationTypeCheck && $attestationTypeCheck->requires_date_range && (!$requestData['start_date'] || !$requestData['end_date'])) {
        echo "✗ Ce type d'attestation nécessite une période (date de début et fin)\n";
    } else {
        echo "✓ Exigences de dates respectées\n";
    }
    
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}