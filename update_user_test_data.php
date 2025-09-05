<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Récupérer l'utilisateur
$user = User::where('id', 1)->first();

if ($user) {
    echo "=== Avant mise à jour ===\n";
    echo "État civil: '" . $user->marital_status . "'\n";
    echo "Statut professionnel: '" . $user->employment_status . "'\n";
    echo "Catégorie: '" . $user->category . "'\n";
    echo "Civilité: '" . $user->gender . "'\n";
    echo "Nombre d'enfants: '" . $user->children_count . "'\n";
    echo "Matricule: '" . $user->matricule . "'\n";
    echo "Affectation: '" . $user->affectation . "'\n";
    echo "Section: '" . $user->section . "'\n";
    echo "Service: '" . $user->service . "'\n";
    
    // Mettre à jour avec des données de test
    $user->update([
        'gender' => 'M',
        'marital_status' => User::MARITAL_STATUS_MARRIED,
        'employment_status' => User::EMPLOYMENT_STATUS_CIVIL_SERVANT,
        'category' => User::CATEGORY_EXECUTIVE,
        'children_count' => 2,
        'matricule' => 'MAT001',
        'affectation' => 'Direction Générale',
        'section' => 'Section Administrative',
        'service' => 'Service RH'
    ]);
    
    // Recharger l'utilisateur
    $user->refresh();
    
    echo "\n=== Après mise à jour ===\n";
    echo "État civil: '" . $user->marital_status . "'\n";
    echo "Statut professionnel: '" . $user->employment_status . "'\n";
    echo "Catégorie: '" . $user->category . "'\n";
    echo "Civilité: '" . $user->gender . "'\n";
    echo "Nombre d'enfants: '" . $user->children_count . "'\n";
    echo "Matricule: '" . $user->matricule . "'\n";
    echo "Affectation: '" . $user->affectation . "'\n";
    echo "Section: '" . $user->section . "'\n";
    echo "Service: '" . $user->service . "'\n";
    
    echo "\n=== Test des méthodes Label ===\n";
    echo "getMaritalStatusLabel(): '" . $user->getMaritalStatusLabel() . "'\n";
    echo "getEmploymentStatusLabel(): '" . $user->getEmploymentStatusLabel() . "'\n";
    echo "getCategoryLabel(): '" . $user->getCategoryLabel() . "'\n";
    
    echo "\n✅ Utilisateur mis à jour avec succès !\n";
    
} else {
    echo "❌ Aucun utilisateur trouvé avec l'ID 1\n";
}