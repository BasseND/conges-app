<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Vérifier d'abord si les colonnes existent
    echo "🔍 Vérification de la structure de la table users...\n";
    
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
    $newFields = ['marital_status', 'employment_status', 'children_count', 'matricule', 'affectation', 'category', 'section', 'service'];
    
    echo "Colonnes existantes: " . implode(', ', $columns) . "\n\n";
    
    foreach ($newFields as $field) {
        if (in_array($field, $columns)) {
            echo "✅ Colonne '{$field}' existe\n";
        } else {
            echo "❌ Colonne '{$field}' manquante\n";
        }
    }
    
    echo "\n📝 Test avec un utilisateur existant...\n";
    
    // Prendre le premier utilisateur ou en créer un simple
    $user = App\Models\User::first();
    
    if (!$user) {
        echo "Aucun utilisateur trouvé, création d'un utilisateur simple...\n";
        $user = new App\Models\User();
        $user->first_name = 'Test';
        $user->last_name = 'User';
        $user->email = 'test@example.com';
        $user->password = bcrypt('password');
        $user->save();
        echo "Utilisateur créé avec ID: {$user->id}\n";
    }
    
    echo "\n🔄 Mise à jour des nouveaux champs...\n";
    
    // Mettre à jour seulement les nouveaux champs
    $user->marital_status = 'married';
    $user->employment_status = 'permanent';
    $user->children_count = 2;
    $user->matricule = 'EMP001';
    $user->affectation = 'Siège social';
    $user->category = 'A';
    $user->section = 'IT';
    $user->service = 'Développement';
    
    $user->save();
    
    echo "✅ Utilisateur mis à jour avec succès!\n";
    echo "ID: {$user->id}\n";
    echo "Nom complet: {$user->first_name} {$user->last_name}\n";
    echo "Email: {$user->email}\n";
    echo "Civilité: {$user->getMaritalStatusLabel()}\n";
    echo "Statut professionnel: {$user->getEmploymentStatusLabel()}\n";
    echo "Nombre d'enfants: {$user->children_count}\n";
    echo "Matricule: {$user->matricule}\n";
    echo "Affectation: {$user->affectation}\n";
    echo "Catégorie: {$user->getCategoryLabel()}\n";
    echo "Section: {$user->section}\n";
    echo "Service: {$user->service}\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors de la création de l'utilisateur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}