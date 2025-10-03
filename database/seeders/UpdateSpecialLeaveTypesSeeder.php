<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecialLeaveType;

class UpdateSpecialLeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mettre à jour les types de congés existants avec le champ has_balance
        
        // Congé annuel - avec solde limité
        SpecialLeaveType::where('system_name', 'conge_annuel')
            ->update(['has_balance' => true]);
        
        // Congé maternité - illimité (selon la loi)
        SpecialLeaveType::where('system_name', 'conge_maternite')
            ->update(['has_balance' => false]);
        
        // Congé paternité - illimité (selon la loi)
        SpecialLeaveType::where('system_name', 'conge_paternite')
            ->update(['has_balance' => false]);
        
        // Congé maladie - avec solde limité
        SpecialLeaveType::where('system_name', 'conge_maladie')
            ->update(['has_balance' => true]);
        
        $this->command->info('Types de congés spéciaux mis à jour avec le champ has_balance');
    }
}
