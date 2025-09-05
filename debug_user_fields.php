<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Récupérer un utilisateur avec des données
$user = User::where('id', 1)->first();

if ($user) {
    echo "=== Données brutes de l'utilisateur ===\n";
    echo "ID: " . $user->id . "\n";
    echo "Nom: " . $user->first_name . " " . $user->last_name . "\n";
    echo "État civil (brut): '" . $user->marital_status . "'\n";
    echo "Statut professionnel (brut): '" . $user->employment_status . "'\n";
    echo "Catégorie (brut): '" . $user->category . "'\n";
    
    echo "\n=== Constantes du modèle ===\n";
    echo "MARITAL_STATUS_MARRIED: '" . User::MARITAL_STATUS_MARRIED . "'\n";
    echo "MARITAL_STATUS_SINGLE: '" . User::MARITAL_STATUS_SINGLE . "'\n";
    echo "MARITAL_STATUS_WIDOWED: '" . User::MARITAL_STATUS_WIDOWED . "'\n";
    
    echo "\nEMPLOYMENT_STATUS_CIVIL_SERVANT: '" . User::EMPLOYMENT_STATUS_CIVIL_SERVANT . "'\n";
    echo "EMPLOYMENT_STATUS_PERMANENT_CONTRACT: '" . User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT . "'\n";
    echo "EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT: '" . User::EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT . "'\n";
    
    echo "\nCATEGORY_EXECUTIVE: '" . User::CATEGORY_EXECUTIVE . "'\n";
    echo "CATEGORY_SUPERVISOR: '" . User::CATEGORY_SUPERVISOR . "'\n";
    echo "CATEGORY_EMPLOYEE: '" . User::CATEGORY_EMPLOYEE . "'\n";
    echo "CATEGORY_WORKER: '" . User::CATEGORY_WORKER . "'\n";
    
    echo "\n=== Options disponibles ===\n";
    echo "Marital Status Options:\n";
    $maritalOptions = User::getMaritalStatusOptions();
    foreach ($maritalOptions as $key => $value) {
        echo "  '$key' => '$value'\n";
    }
    
    echo "\nEmployment Status Options:\n";
    $employmentOptions = User::getEmploymentStatusOptions();
    foreach ($employmentOptions as $key => $value) {
        echo "  '$key' => '$value'\n";
    }
    
    echo "\nCategory Options:\n";
    $categoryOptions = User::getCategoryOptions();
    foreach ($categoryOptions as $key => $value) {
        echo "  '$key' => '$value'\n";
    }
    
    echo "\n=== Résultats des méthodes Label ===\n";
    echo "getMaritalStatusLabel(): '" . $user->getMaritalStatusLabel() . "'\n";
    echo "getEmploymentStatusLabel(): '" . $user->getEmploymentStatusLabel() . "'\n";
    echo "getCategoryLabel(): '" . $user->getCategoryLabel() . "'\n";
    
    echo "\n=== Test de correspondance ===\n";
    echo "Marital status existe dans les options: " . (array_key_exists($user->marital_status, $maritalOptions) ? 'OUI' : 'NON') . "\n";
    echo "Employment status existe dans les options: " . (array_key_exists($user->employment_status, $employmentOptions) ? 'OUI' : 'NON') . "\n";
    echo "Category existe dans les options: " . (array_key_exists($user->category, $categoryOptions) ? 'OUI' : 'NON') . "\n";
    
} else {
    echo "Aucun utilisateur trouvé avec l'ID 1\n";
}