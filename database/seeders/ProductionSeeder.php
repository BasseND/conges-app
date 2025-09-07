<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Team;
use App\Models\Leave;
use App\Models\SpecialLeaveType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Départements
        $this->command->info('Création des départements...');
        
        // Vérifier si les départements existent déjà
        if (!Department::where('code', 'IT')->exists()) {
            Department::create(['name' => 'Informatique', 'code' => 'IT']);
        }
        
        if (!Department::where('code', 'HR')->exists()) {
            Department::create(['name' => 'Ressources Humaines', 'code' => 'HR']);
        }
        
        if (!Department::where('code', 'FIN')->exists()) {
            Department::create(['name' => 'Finance', 'code' => 'FIN']);
        }
        
        if (!Department::where('code', 'MKT')->exists()) {
            Department::create(['name' => 'Marketing', 'code' => 'MKT']);
        }
        
        if (!Department::where('code', 'OPS')->exists()) {
            Department::create(['name' => 'Opérations', 'code' => 'OPS']);
        }

        // Récupérer les départements
        $itDept = Department::where('code', 'IT')->first();
        $hrDept = Department::where('code', 'HR')->first();
        $finDept = Department::where('code', 'FIN')->first();

        // Créer les managers d'abord
        $this->command->info('Création des utilisateurs...');
        
        $webManager = User::firstOrCreate(
            ['email' => 'web.manager@example.com'],
            [
                'first_name' => 'Web Team Manager',
                'last_name' => 'Web Team Manager',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'role' => User::ROLE_MANAGER,
                'department_id' => $itDept->id,
                'employee_id' => 'IT002',
                'email_verified_at' => now(),
            ]
        );

        $infraManager = User::firstOrCreate(
            ['email' => 'infra.manager@example.com'],
            [
                'first_name' => 'Infrastructure Manager',
                'last_name' => 'Infrastructure Manager',
                'phone' => '1234567891',
                'password' => Hash::make('password'),
                'role' => User::ROLE_MANAGER,
                'department_id' => $itDept->id,
                'employee_id' => 'IT006',
                'email_verified_at' => now(),
            ]
        );

        $hrTeamManager = User::firstOrCreate(
            ['email' => 'hr.manager@example.com'],
            [
                'first_name' => 'HR Team Manager',
                'last_name' => 'HR Team Manager',
                'phone' => '1234567892',
                'password' => Hash::make('password'),
                'role' => User::ROLE_MANAGER,
                'department_id' => $hrDept->id,
                'employee_id' => 'HR002',
                'email_verified_at' => now(),
            ]
        );

        $financeManager = User::firstOrCreate(
            ['email' => 'finance.manager@example.com'],
            [
                'first_name' => 'Finance Manager',
                'last_name' => 'Finance Manager',
                'phone' => '1234567893',
                'password' => Hash::make('password'),
                'role' => User::ROLE_MANAGER,
                'department_id' => $finDept->id,
                'employee_id' => 'FIN002',
                'email_verified_at' => now(),
            ]
        );

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
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => '1234567890',
                'position' => 'Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'department_id' => $itDept->id,
                'employee_id' => 'ADMIN001',
                'email_verified_at' => now(),
            ]
        );

        // HR Manager
        $hrManager = User::firstOrCreate(
            ['email' => 'hr@example.com'],
            [
                'first_name' => 'HR',
                'last_name' => 'Manager',
                'phone' => '1234567890',
                'position' => 'HR Manager',
                'password' => Hash::make('password'),
                'role' => User::ROLE_HR,
                'department_id' => $hrDept->id,
                'employee_id' => 'HR001',
                'email_verified_at' => now(),
            ]
        );

        // Chef de département IT
        $itHead = User::firstOrCreate(
            ['email' => 'it.head@example.com'],
            [
                'first_name' => 'IT Department Head',
                'last_name' => 'IT Department Head',
                'phone' => '1234567890',
                'position' => 'IT Department Head',
                'password' => Hash::make('password'),
                'role' => User::ROLE_DEPARTMENT_HEAD,
                'department_id' => $itDept->id,
                'employee_id' => 'IT001',
                'email_verified_at' => now(),
            ]
        );

        // Employés
        $employee1 = User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'first_name' => 'John',
                'last_name' => 'Developer',
                'phone' => '1234567890',
                'position' => 'Developer',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EMPLOYEE,
                'department_id' => $itDept->id,
                'employee_id' => 'IT008',
                'email_verified_at' => now(),
            ]
        );

        $employee2 = User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'first_name' => 'Jane',
                'last_name' => 'Developer',
                'phone' => '1234567890',
                'position' => 'Developer',
                'password' => Hash::make('password'),
                'role' => User::ROLE_EMPLOYEE,
                'department_id' => $itDept->id,
                'employee_id' => 'IT007',
                'email_verified_at' => now(),
            ]
        );

        // Associer les utilisateurs aux équipes
        $webManager->teams()->attach($team1->id);
        $employee1->teams()->attach($team1->id);
        $employee2->teams()->attach($team1->id);

        // Créer les types de congés spéciaux par défaut
        $this->command->info('Création des types de congés spéciaux par défaut...');
        
        // Congé annuel
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_annuel'],
            [
                'name' => 'Congé annuel',
                'duration_days' => 25,
                'description' => 'Congé annuel standard pour tous les employés',
                'is_active' => true,
            ]
        );
        
        // Congé maternité
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_maternite'],
            [
                'name' => 'Congé maternité',
                'duration_days' => 112, // 16 semaines
                'description' => 'Congé maternité pour les employées enceintes',
                'is_active' => true,
            ]
        );
        
        // Congé paternité
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_paternite'],
            [
                'name' => 'Congé paternité',
                'duration_days' => 28, // 4 semaines
                'description' => 'Congé paternité pour les nouveaux pères',
                'is_active' => true,
            ]
        );
        
        // Congé maladie
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_maladie'],
            [
                'name' => 'Congé maladie',
                'duration_days' => 30,
                'description' => 'Congé maladie pour les employés malades',
                'is_active' => true,
            ]
        );
        
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
