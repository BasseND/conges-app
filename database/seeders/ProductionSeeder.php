<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        // Créer les départements de base
        $departments = [
            [
                'name' => 'Ressources Humaines',
                'code' => 'RH',
                'description' => 'Département des ressources humaines'
            ],
            [
                'name' => 'Informatique',
                'code' => 'IT',
                'description' => 'Département informatique'
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Département finance'
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }

        // Créer un utilisateur admin par défaut
        User::create([
            'name' => 'Admin',
            'email' => 'admin@conges-app.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // À changer après le premier login
            'role' => 'admin',
            'department_id' => Department::where('code', 'IT')->first()->id,
            'employee_id' => 'ADMIN001', // Ajout de l'employee_id
        ]);

         // Créer des congés
         $statuses = ['pending', 'approved', 'rejected'];
         $types = ['annual', 'sick', 'unpaid', 'other'];
         $users = User::where('role', 'employee')->get();
 
         foreach ($users as $user) {
             // Congés sur les 12 derniers mois
             for ($i = 1; $i <= 5; $i++) {
                 $startDate = Carbon::now()->subMonths(rand(0, 11))->subDays(rand(0, 28));
                 $duration = rand(1, 5);
                 $endDate = $startDate->copy()->addDays($duration - 1);
                 
                 Leave::create([
                     'user_id' => $user->id,
                     'start_date' => $startDate,
                     'end_date' => $endDate,
                     'duration' => $duration,
                     'status' => $statuses[array_rand($statuses)],
                     'type' => $types[array_rand($types)],
                     'reason' => 'Congés ' . $types[array_rand($types)],
                 ]);
             }
         }

    }
}
