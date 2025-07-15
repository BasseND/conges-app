<?php

require_once 'vendor/autoload.php';

// Charger l'application Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo "=== DIAGNOSTIC D'AUTHENTIFICATION ===\n\n";

// Simuler une connexion avec l'utilisateur admin
$adminUser = User::where('email', 'admin@example.com')->first();
if ($adminUser) {
    Auth::login($adminUser);
    
    echo "Utilisateur connecté: {$adminUser->email}\n";
    echo "Rôle: {$adminUser->role}\n";
    echo "Actif: " . ($adminUser->is_active ? 'Oui' : 'Non') . "\n";
    echo "Auth::check(): " . (Auth::check() ? 'true' : 'false') . "\n";
    echo "Auth::user()->role: " . Auth::user()->role . "\n";
    
    // Tester le middleware manuellement
    $allowedRoles = ['admin', 'hr'];
    $userRole = Auth::user()->role;
    $hasAccess = in_array($userRole, $allowedRoles);
    
    echo "\n=== TEST MIDDLEWARE ===\n";
    echo "Rôles autorisés: " . implode(', ', $allowedRoles) . "\n";
    echo "Rôle utilisateur: {$userRole}\n";
    echo "Accès autorisé: " . ($hasAccess ? 'OUI' : 'NON') . "\n";
    
    // Vérifier les méthodes du modèle User
    echo "\n=== MÉTHODES DU MODÈLE USER ===\n";
    echo "isAdmin(): " . ($adminUser->isAdmin() ? 'true' : 'false') . "\n";
    echo "isHR(): " . ($adminUser->isHR() ? 'true' : 'false') . "\n";
    
} else {
    echo "Utilisateur admin non trouvé!\n";
}

// Tester avec l'utilisateur basse@test.com aussi
echo "\n=== TEST AVEC BASSE@TEST.COM ===\n";
$basseUser = User::where('email', 'basse@test.com')->first();
if ($basseUser) {
    Auth::login($basseUser);
    
    echo "Utilisateur connecté: {$basseUser->email}\n";
    echo "Rôle: {$basseUser->role}\n";
    echo "Actif: " . ($basseUser->is_active ? 'Oui' : 'Non') . "\n";
    
    $allowedRoles = ['admin', 'hr'];
    $userRole = Auth::user()->role;
    $hasAccess = in_array($userRole, $allowedRoles);
    
    echo "Accès autorisé: " . ($hasAccess ? 'OUI' : 'NON') . "\n";
    echo "isAdmin(): " . ($basseUser->isAdmin() ? 'true' : 'false') . "\n";
} else {
    echo "Utilisateur basse@test.com non trouvé!\n";
}