<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\LeaveBalance;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un solde de congés par défaut pour chaque entreprise existante
        $companies = Company::all();
        
        foreach ($companies as $company) {
            // Vérifier si l'entreprise a déjà un solde par défaut
            $existingDefault = LeaveBalance::where('company_id', $company->id)
                ->where('is_default', true)
                ->first();
                
            if (!$existingDefault) {
                LeaveBalance::create([
                    'company_id' => $company->id,
                    'annual_leave_days' => 25,
                    'maternity_leave_days' => 112, // 16 semaines
                    'paternity_leave_days' => 25,
                    'special_leave_days' => 5,
                    'is_default' => true,
                    'description' => 'Solde de congés par défaut pour ' . $company->name
                ]);
            }
        }
        
        // Créer quelques exemples de soldes personnalisés
        $firstCompany = Company::first();
        if ($firstCompany) {
            // Solde pour cadres
            LeaveBalance::create([
                'company_id' => $firstCompany->id,
                'annual_leave_days' => 30,
                'maternity_leave_days' => 112,
                'paternity_leave_days' => 25,
                'special_leave_days' => 8,
                'is_default' => false,
                'description' => 'Solde de congés pour cadres'
            ]);
            
            // Solde pour stagiaires
            LeaveBalance::create([
                'company_id' => $firstCompany->id,
                'annual_leave_days' => 15,
                'maternity_leave_days' => 112,
                'paternity_leave_days' => 25,
                'special_leave_days' => 3,
                'is_default' => false,
                'description' => 'Solde de congés pour stagiaires'
            ]);
        }
    }
}