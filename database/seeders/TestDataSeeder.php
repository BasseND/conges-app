<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Créer les départements
        $departments = [
            ['name' => 'Ressources Humaines', 'code' => 'RH'],
            ['name' => 'Développement', 'code' => 'DEV'],
            ['name' => 'Marketing', 'code' => 'MKT'],
            ['name' => 'Finance', 'code' => 'FIN'],
            ['name' => 'Support', 'code' => 'SUP']
        ];

        foreach ($departments as $dept) {
            Department::create([
                'name' => $dept['name'],
                'code' => $dept['code'],
                'description' => "Département {$dept['name']}"
            ]);
        }

        // Créer un admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => Department::inRandomOrder()->first()->id,
            'employee_id' => 'ADM001'
        ]);

        // Créer des managers
        foreach (Department::all() as $department) {
            $manager = User::create([
                'name' => "Manager {$department->name}",
                'email' => "manager.{$department->id}@example.com",
                'password' => Hash::make('password'),
                'role' => 'manager',
                'department_id' => $department->id,
                'employee_id' => 'MGR' . str_pad($department->id, 3, '0', STR_PAD_LEFT)
            ]);

            // Mettre à jour le manager_id du département
            $department->manager_id = $manager->id;
            $department->save();
        }

        // Créer des employés
        foreach (Department::all() as $department) {
            for ($i = 1; $i <= 3; $i++) {
                User::create([
                    'name' => "Employé {$i} {$department->name}",
                    'email' => "employee.{$department->id}.{$i}@example.com",
                    'password' => Hash::make('password'),
                    'role' => 'employee',
                    'department_id' => $department->id,
                    'employee_id' => 'EMP' . str_pad($department->id, 3, '0', STR_PAD_LEFT) . str_pad($i, 2, '0', STR_PAD_LEFT)
                ]);
            }
        }

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
