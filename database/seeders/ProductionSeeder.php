<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Team;
use App\Models\Leave;
use App\Models\SpecialLeaveType;
use App\Models\AttestationType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {

        // Société 
        $this->command->info('Création de la société par défaut...');
        
        // Créer une société par défaut si elle n'existe pas
        if (!\App\Models\Company::exists()) {
            \App\Models\Company::create([
                'name' => 'Mon Entreprise',
                'director_name' => 'Directeur Général',
                'hr_director_name' => 'Directeur RH',
                'hr_signature' => null,
                'logo' => null,
                'website_url' => 'https://www.monentreprise.com',
                'address' => '123 Rue de l\'Entreprise',
                'city' => 'Ville',
                'country' => 'Sénégal',
                'postal_code' => '12345',
                'registration_number' => '12345678901234',
                'location' => 'Ville, Sénégal',
                'contact_email' => 'contact@monentreprise.com',
                'contact_phone' => '+221 523 45 67',
                'currency' => 'XOF',
                'salary_advance_deadline_day' => 25
            ]);
        }
        
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

        // Créer un admin
        $company = \App\Models\Company::first();
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'birth_date' => '1980-01-01',
            'address' => '123 Rue Admin, Ville',
            'marital_status' => 'célibataire',
            'matricule' => 'ADM001',
            'category' => 'cadre',
            'entry_date' => '2020-01-01',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => Department::inRandomOrder()->first()->id,
            'company_id' => $company->id,
            'employee_id' => 'ADM001'
        ]);



        // Créer les types de congés spéciaux par défaut
        $this->command->info('Création des types de congés spéciaux par défaut...');
        
        // Congé annuel
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_annuel'],
            [  
                'name' => 'Congé annuel',
                'type' => SpecialLeaveType::TYPE_SYSTEM,
                'duration_days' => 25,
                'description' => 'Congé annuel standard pour tous les employés',
                'is_active' => true,
                'has_balance' => true, // Congé avec solde limité
            ]
        );
        
        // Congé maternité
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_maternite'],
            [   
                'name' => 'Congé maternité',
                'type' => SpecialLeaveType::TYPE_SYSTEM,
                'duration_days' => 112, // 16 semaines
                'description' => 'Congé maternité pour les employées enceintes',
                'is_active' => true,
                'has_balance' => false, // Congé illimité (selon la loi)
            ]
        );
        
        // Congé paternité
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_paternite'],
            [
                'name' => 'Congé paternité',
                'type' => SpecialLeaveType::TYPE_SYSTEM,
                'duration_days' => 28, // 4 semaines
                'description' => 'Congé paternité pour les nouveaux pères',
                'is_active' => true,
                'has_balance' => false, // Congé illimité (selon la loi)
            ]
        );

       
        // Congé maladie
        SpecialLeaveType::firstOrCreate(
            ['system_name' => 'conge_maladie'],
            [
                'name' => 'Congé maladie',
                'type' => SpecialLeaveType::TYPE_SYSTEM,
                'duration_days' => 30,
                'description' => 'Congé maladie pour les employés malades',
                'is_active' => true,
                'has_balance' => true, // Congé avec solde limité
            ]
        );
        
        // Types d'attestation
        $this->command->info('Création des types d\'attestation...');
        $this->call(AttestationTypeSeeder::class);
       
    }
}
