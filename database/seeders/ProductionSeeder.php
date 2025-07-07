<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Team;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Départements
        Department::create(['name' => 'Informatique', 'code' => 'IT']);
        Department::create(['name' => 'Ressources Humaines', 'code' => 'HR']);
        Department::create(['name' => 'Finance', 'code' => 'FIN']);
        Department::create(['name' => 'Marketing', 'code' => 'MKT']);
        Department::create(['name' => 'Opérations', 'code' => 'OPS']);

        // Récupérer les départements
        $itDept = Department::where('code', 'IT')->first();
        $hrDept = Department::where('code', 'HR')->first();
        $finDept = Department::where('code', 'FIN')->first();

        // Créer les managers d'abord
        $webManager = User::create([
            'first_name' => 'Web Team Manager',
            'last_name' => 'Web Team Manager',
            'email' => 'web.manager@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,

            'department_id' => $itDept->id,
            'employee_id' => 'IT002',
            'email_verified_at' => now(),
        ]);

        $infraManager = User::create([
            'first_name' => 'Infrastructure Manager',
            'last_name' => 'Infrastructure Manager',
            'email' => 'infra.manager@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,

            'department_id' => $itDept->id,
            'employee_id' => 'IT005',
            'email_verified_at' => now(),
        ]);

        $hrTeamManager = User::create([
            'first_name' => 'HR Team Manager',
            'last_name' => 'HR Team Manager',
            'email' => 'hr.team@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,

            'department_id' => $hrDept->id,
            'employee_id' => 'HR002',
            'email_verified_at' => now(),
        ]);

        $financeManager = User::create([
            'first_name' => 'Finance Manager',
            'last_name' => 'Finance Manager',
            'email' => 'finance.manager@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,

            'department_id' => $finDept->id,
            'employee_id' => 'FIN001',
            'email_verified_at' => now(),
        ]);

        // Équipes avec leurs managers
        $team1 = Team::create([
            'name' => 'Développement Web',
            'department_id' => $itDept->id,
            'manager_id' => $webManager->id
        ]);

        $team2 = Team::create([
            'name' => 'Infrastructure',
            'department_id' => $itDept->id,
            'manager_id' => $infraManager->id
        ]);

        $team3 = Team::create([
            'name' => 'Recrutement',
            'department_id' => $hrDept->id,
            'manager_id' => $hrTeamManager->id
        ]);

        $team4 = Team::create([
            'name' => 'Comptabilité',
            'department_id' => $finDept->id,
            'manager_id' => $financeManager->id
        ]);

        // Admin utilisateur
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'position' => 'Admin',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,

            'department_id' => $itDept->id,
            'employee_id' => 'ADMIN001',
            'email_verified_at' => now(),
        ]);

        // HR Manager
        $hrManager = User::create([
            'first_name' => 'HR',
            'last_name' => 'Manager',
            'email' => 'hr@example.com',
            'phone' => '1234567890',
            'position' => 'HR Manager',
            'password' => Hash::make('password'),
            'role' => User::ROLE_HR,

            'department_id' => $hrDept->id,
            'employee_id' => 'HR001',
            'email_verified_at' => now(),
        ]);

        // Chef de département IT
        $itHead = User::create([
            'first_name' => 'IT Department Head',
            'last_name' => 'IT Department Head',
            'email' => 'it.head@example.com',
            'phone' => '1234567890',
            'position' => 'IT Department Head',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DEPARTMENT_HEAD,

            'department_id' => $itDept->id,
            'employee_id' => 'IT001',
            'email_verified_at' => now(),
        ]);

        // Employés
        $employee1 = User::create([
            'first_name' => 'John',
            'last_name' => 'Developer',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'position' => 'Developer',
            'password' => Hash::make('password'),
            'role' => User::ROLE_EMPLOYEE,

            'department_id' => $itDept->id,
            'employee_id' => 'IT003',
            'email_verified_at' => now(),
        ]);

        $employee2 = User::create([
            'first_name' => 'Jane',
            'last_name' => 'Developer',
            'email' => 'jane@example.com',
            'phone' => '1234567890',
            'position' => 'Developer',
            'password' => Hash::make('password'),
            'role' => User::ROLE_EMPLOYEE,

            'department_id' => $itDept->id,
            'employee_id' => 'IT004',
            'email_verified_at' => now(),
        ]);

        // Associer les utilisateurs aux équipes
        $webManager->teams()->attach($team1->id);
        $employee1->teams()->attach($team1->id);
        $employee2->teams()->attach($team1->id);

        // Créer des congés
        $statuses = ['pending', 'approved', 'rejected'];
        $types = ['annual', 'sick', 'unpaid', 'other'];
        $users = User::where('role', User::ROLE_EMPLOYEE)->get();

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
