<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SpecialLeaveType;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de test s'il n'existe pas
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'password' => bcrypt('password'),
                'role' => 'employee',
                'email_verified_at' => now(),
                'birth_date' => '1990-01-01',
                'address' => '123 Rue de Test, Ville Test',
                'marital_status' => 'single',
                'employment_status' => 'permanent_contract',
                'matricule' => 'TEST001',
                'category' => 'employee',
                'entry_date' => '2024-01-01',
                'gender' => 'M',
                'position' => 'Développeur',
                'department_id' => 1,
                'company_id' => 1,
                'is_active' => true,
            ]
        );

        $this->command->info("Utilisateur créé/trouvé: {$user->first_name} {$user->last_name} (ID: {$user->id})");

        // Créer des types de congés de test
        $leaveTypes = [
            [
                'name' => 'Congé Annuel',
                'duration_days' => 25,
                'description' => 'Congés payés annuels',
                'is_active' => true,
                'type' => 'système'
            ],
            [
                'name' => 'Congé Maladie',
                'duration_days' => 10,
                'description' => 'Congés maladie',
                'is_active' => true,
                'type' => 'système'
            ],
            [
                'name' => 'Congé Maternité',
                'duration_days' => 98,
                'description' => 'Congé maternité',
                'is_active' => true,
                'type' => 'système'
            ],
            [
                'name' => 'Congé Paternité',
                'duration_days' => 11,
                'description' => 'Congé paternité',
                'is_active' => true,
                'type' => 'système'
            ]
        ];

        foreach ($leaveTypes as $typeData) {
            $leaveType = SpecialLeaveType::firstOrCreate(
                ['name' => $typeData['name']],
                $typeData
            );
            
            $this->command->info("Type de congé créé/trouvé: {$leaveType->name}");
        }
    }
}
