<?php

require_once 'vendor/autoload.php';

// Charger l'application Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Vérifier les utilisateurs admin
$users = App\Models\User::whereIn('role', ['admin', 'hr'])->get();

echo "=== DIAGNOSTIC DES RÔLES UTILISATEURS ===\n\n";

echo "Constantes de rôles dans le modèle User :\n";
echo "ROLE_ADMIN: " . App\Models\User::ROLE_ADMIN . "\n";
echo "ROLE_HR: " . App\Models\User::ROLE_HR . "\n";
echo "ROLE_MANAGER: " . App\Models\User::ROLE_MANAGER . "\n";
echo "ROLE_EMPLOYEE: " . App\Models\User::ROLE_EMPLOYEE . "\n";
echo "ROLE_DEPARTMENT_HEAD: " . App\Models\User::ROLE_DEPARTMENT_HEAD . "\n\n";

echo "Utilisateurs avec rôle 'admin' ou 'hr' :\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Rôle: '{$user->role}', Actif: " . ($user->is_active ? 'Oui' : 'Non') . "\n";
}

echo "\n=== VÉRIFICATION DES MIDDLEWARES ===\n";
echo "Middleware 'role:admin,hr' accepte les rôles: admin, hr\n";

echo "\n=== TOUS LES UTILISATEURS ===\n";
$allUsers = App\Models\User::all();
foreach ($allUsers as $user) {
    echo "Email: {$user->email}, Rôle: '{$user->role}'\n";
}