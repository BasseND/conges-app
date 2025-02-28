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
            'name' => 'Web Team Manager',
            'email' => 'web.manager@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $itDept->id,
            'employee_id' => 'IT002',
            'email_verified_at' => now(),
        ]);

        $infraManager = User::create([
            'name' => 'Infrastructure Manager',
            'email' => 'infra.manager@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $itDept->id,
            'employee_id' => 'IT005',
            'email_verified_at' => now(),
        ]);

        $hrTeamManager = User::create([
            'name' => 'HR Team Manager',
            'email' => 'hr.team@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $hrDept->id,
            'employee_id' => 'HR002',
            'email_verified_at' => now(),
        ]);

        $financeManager = User::create([
            'name' => 'Finance Manager',
            'email' => 'finance.manager@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MANAGER,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
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
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $itDept->id,
            'employee_id' => 'ADMIN001',
            'email_verified_at' => now(),
        ]);

        // HR Manager
        $hrManager = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_HR,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $hrDept->id,
            'employee_id' => 'HR001',
            'email_verified_at' => now(),
        ]);

        // Chef de département IT
        $itHead = User::create([
            'name' => 'IT Department Head',
            'email' => 'it.head@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DEPARTMENT_HEAD,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $itDept->id,
            'employee_id' => 'IT001',
            'email_verified_at' => now(),
        ]);

        // Employés
        $employee1 = User::create([
            'name' => 'John Developer',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_EMPLOYEE,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
            'department_id' => $itDept->id,
            'employee_id' => 'IT003',
            'email_verified_at' => now(),
        ]);

        $employee2 = User::create([
            'name' => 'Jane Developer',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_EMPLOYEE,
            'annual_leave_days' => 25,
            'sick_leave_days' => 12,
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
