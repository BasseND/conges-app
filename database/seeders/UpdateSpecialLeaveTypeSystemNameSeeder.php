<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SpecialLeaveType;

class UpdateSpecialLeaveTypeSystemNameSeeder extends Seeder
{
    /**
     * Exécute le seeder pour mettre à jour les system_name des types de congés spéciaux.
     */
    public function run(): void
    {
        $specialLeaveTypes = SpecialLeaveType::all();
        
        foreach ($specialLeaveTypes as $type) {
            if (empty($type->system_name)) {
                $type->system_name = SpecialLeaveType::generateSystemName($type->name);
                $type->save();
                
                $this->command->info("Type de congé mis à jour: {$type->name} -> {$type->system_name}");
            }
        }
        
        $this->command->info("Mise à jour des system_name terminée.");
    }
}