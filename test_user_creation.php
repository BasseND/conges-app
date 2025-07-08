<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Log;

echo "Creating test user...\n";

// Créer un utilisateur de test
$user = User::create([
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'test' . time() . '@example.com',
    'password' => bcrypt('password'),
    'position' => 'Test Position',
    'role' => 'employee',
    'department_id' => 1,
    'employee_id' => 'TEST' . time()
]);

echo "User created with ID: " . $user->id . "\n";
echo "Email: " . $user->email . "\n";

// Déclencher l'événement
echo "Triggering UserCreated event...\n";
event(new UserCreated($user));
echo "Event triggered successfully\n";

// Vérifier les notifications créées
$notifications = \App\Models\Notification::where('data->user_id', $user->id)->get();
echo "Notifications created: " . $notifications->count() . "\n";

foreach ($notifications as $notification) {
    echo "- Notification for user ID: " . $notification->user_id . " - " . $notification->title . "\n";
}