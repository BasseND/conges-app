<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LeaveBalance;
use App\Models\SpecialLeaveType;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        
        // Récupérer tous les types de congés
        $specialLeaveTypes = SpecialLeaveType::all();
        
        foreach ($users as $user) {
            foreach ($specialLeaveTypes as $specialLeaveType) {
                // Créer un solde pour chaque utilisateur et chaque type de congé
                $allocatedDays = $this->getAllocatedDays($specialLeaveType->name);
                $usedDays = $this->getUsedDays($specialLeaveType->name);
                
                LeaveBalance::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'leave_type_id' => $specialLeaveType->id,
                        'year' => now()->year,
                    ],
                    [
                        'allocated_days' => $allocatedDays,
                        'used_days' => $usedDays,
                        'remaining_days' => $allocatedDays - $usedDays,
                    ]
                );
            }
        }
    }
    
    /**
     * Obtenir le nombre de jours alloués selon le type de congé
     */
    private function getAllocatedDays(string $leaveTypeName): int
    {
        return match(strtolower($leaveTypeName)) {
            'annual leave', 'congé annuel', 'vacation' => 25,
            'sick leave', 'congé maladie' => 10,
            'maternity leave', 'congé maternité' => 98,
            'paternity leave', 'congé paternité' => 11,
            'personal leave', 'congé personnel' => 5,
            default => 20,
        };
    }
    
    /**
     * Obtenir le nombre de jours utilisés (simulation)
     */
    private function getUsedDays(string $leaveTypeName): int
    {
        return match(strtolower($leaveTypeName)) {
            'annual leave', 'congé annuel', 'vacation' => rand(0, 10),
            'sick leave', 'congé maladie' => rand(0, 3),
            'maternity leave', 'congé maternité' => 0,
            'paternity leave', 'congé paternité' => 0,
            'personal leave', 'congé personnel' => rand(0, 2),
            default => rand(0, 5),
        };
    }
}
