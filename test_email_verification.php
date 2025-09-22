<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

echo "=== Test de vérification d'email ===\n";

// Vérifier que les routes existent
echo "\n1. Vérification des routes:\n";
$routes = collect(Route::getRoutes())->filter(function ($route) {
    return str_contains($route->getName() ?? '', 'verification');
});

foreach ($routes as $route) {
    echo "  - {$route->getName()}: {$route->uri()}\n";
}

// Créer un utilisateur de test
echo "\n2. Création d'un utilisateur de test:\n";
$user = User::create([
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'test.verification@example.com',
    'password' => bcrypt('password'),
    'role' => 'employee',
    'employee_id' => 'TEST_' . time(),
    'department_id' => 1,
    'email_verified_at' => null
]);
echo "  Utilisateur créé: {$user->email}\n";
echo "  Email vérifié: " . ($user->hasVerifiedEmail() ? 'OUI' : 'NON') . "\n";

// Générer une URL de vérification
echo "\n3. Génération de l'URL de vérification:\n";
$verificationUrl = URL::temporarySignedRoute(
    'verification.verify',
    now()->addMinutes(60),
    ['id' => $user->id, 'hash' => sha1($user->email)]
);
echo "  URL: {$verificationUrl}\n";

// Vérifier la signature
echo "\n4. Test de validation de signature:\n";
$parsedUrl = parse_url($verificationUrl);
parse_str($parsedUrl['query'] ?? '', $queryParams);
echo "  Paramètres: " . json_encode($queryParams) . "\n";

// Nettoyer
$user->delete();
echo "\n5. Utilisateur de test supprimé\n";

echo "\n=== Test terminé ===\n";