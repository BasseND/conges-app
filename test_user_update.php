<?php

require_once 'vendor/autoload.php';

// Charger l'application Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Department;
use App\Models\Notification;
use App\Events\UserUpdated;

echo "=== Test de mise à jour d'utilisateur et notifications ===\n\n";

// Trouver un utilisateur existant
$user = User::where('role', '!=', 'admin')->first();
if (!$user) {
    echo "Aucun utilisateur trouvé pour le test.\n";
    exit;
}

echo "Utilisateur sélectionné: {$user->first_name} {$user->last_name} ({$user->email})\n";
echo "Rôle actuel: {$user->role}\n";
echo "Département actuel: " . ($user->department_id ? $user->department->name ?? 'Inconnu' : 'Aucun') . "\n\n";

// Sauvegarder les anciennes données
$oldData = [
    'role' => $user->role,
    'department_id' => $user->department_id,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email
];

// Modifier le rôle
$newRole = $user->role === 'employee' ? 'manager' : 'employee';
$user->role = $newRole;

// Modifier le département si possible
$departments = Department::all();
if ($departments->count() > 1) {
    $newDepartment = $departments->where('id', '!=', $user->department_id)->first();
    if ($newDepartment) {
        $user->department_id = $newDepartment->id;
    }
}

$user->save();

echo "Nouvelles données:\n";
echo "Nouveau rôle: {$user->role}\n";
echo "Nouveau département: " . ($user->department_id ? $user->department->name ?? 'Inconnu' : 'Aucun') . "\n\n";

// Préparer les nouvelles données
$newData = [
    'role' => $user->role,
    'department_id' => $user->department_id,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email
];

echo "Déclenchement de l'événement UserUpdated...\n";

// Déclencher l'événement
event(new UserUpdated($user, $oldData, $newData));

echo "Événement UserUpdated déclenché avec succès!\n\n";

// Vérifier les notifications créées
$notifications = Notification::where('created_at', '>=', now()->subMinutes(1))
    ->orderBy('created_at', 'desc')
    ->get();

echo "Notifications créées (dernière minute): " . $notifications->count() . "\n";

foreach ($notifications as $notification) {
    echo "- Type: {$notification->type}\n";
    echo "  Titre: {$notification->title}\n";
    echo "  Message: {$notification->message}\n";
    echo "  Utilisateur: " . $notification->user->email . "\n";
    echo "  Priorité: {$notification->priority}\n";
    echo "  Catégorie: {$notification->category}\n\n";
}

echo "Test terminé!\n";