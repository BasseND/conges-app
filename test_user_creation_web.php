<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Department;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

echo "Testing user creation with UserCreated event...\n";

// Simuler la création d'un utilisateur comme dans le contrôleur web
try {
    $department = Department::first();
    if (!$department) {
        echo "No department found. Creating one...\n";
        $department = Department::create([
            'name' => 'Test Department',
            'description' => 'Test department for user creation'
        ]);
    }
    
    $userData = [
        'first_name' => 'Test',
        'last_name' => 'User Web',
        'email' => 'testweb' . time() . '@example.com',
        'password' => Hash::make('password123'),
        'position' => 'Test Position',
        'role' => 'employee',
        'department_id' => $department->id,
        'employee_id' => 'EMP' . time(),
        'is_prestataire' => false
    ];
    
    echo "Creating user with data: " . json_encode($userData) . "\n";
    
    $user = User::create($userData);
    echo "User created successfully with ID: " . $user->id . "\n";
    
    // Déclencher l'événement comme dans le contrôleur
    Log::info('About to trigger UserCreated event for user: ' . $user->email);
    event(new UserCreated($user));
    Log::info('UserCreated event triggered successfully for user: ' . $user->email);
    
    echo "UserCreated event triggered for user: " . $user->email . "\n";
    
    // Vérifier les notifications créées
    $notifications = \App\Models\Notification::where('type', 'user_created')
        ->where('data->user_id', $user->id)
        ->get();
    
    echo "Notifications created: " . $notifications->count() . "\n";
    foreach ($notifications as $notification) {
        echo "- Notification ID: " . $notification->id . " for user ID: " . $notification->user_id . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "Test completed.\n";