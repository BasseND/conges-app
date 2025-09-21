<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttestationType;
use App\Models\Company;
use App\Models\User;

class AttestationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('role', 'admin')->first();
        if (!$adminUser) {
            $adminUser = User::first();
        }
        
        $types = [
            [
                'name' => 'Attestation de travail',
                'system_name' => 'attestation_de_travail',
                'description' => 'Attestation confirmant l\'emploi du salarié dans l\'entreprise',
                'template_file' => 'attestation_travail',
                'type' => 'employment',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Attestation de salaire',
                'system_name' => 'attestation_de_salaire',
                'description' => 'Attestation indiquant le salaire et les conditions d\'emploi',
                'template_file' => 'attestation_salaire',
                'type' => 'salary',
                'status' => 'active',
                'requires_salary_info' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Attestation de stage',
                'system_name' => 'attestation_de_stage',
                'description' => 'Attestation pour les stagiaires',
                'template_file' => 'attestation_stage',
                'type' => 'custom',
                'status' => 'active',
                'requires_date_range' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Attestation de présence / assiduité',
                'system_name' => 'attestation_de_presence',
                'description' => 'Attestation confirmant la présence et l\'assiduité du salarié',
                'template_file' => 'attestation_presence',
                'type' => 'presence',
                'status' => 'active',
                'requires_date_range' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Certificat de travail',
                'system_name' => 'certificat_de_travail',
                'description' => 'Certificat obligatoire à la fin du contrat de travail',
                'template_file' => 'certificat_travail',
                'type' => 'employment',
                'status' => 'active',
                'requires_date_range' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Solde de tout compte',
                'system_name' => 'solde_tout_compte',
                'description' => 'Document récapitulatif des sommes dues au salarié à la fin du contrat',
                'template_file' => 'solde_tout_compte',
                'type' => 'salary',
                'status' => 'active',
                'requires_salary_info' => true,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($types as $type) {
            AttestationType::updateOrCreate(
                ['system_name' => $type['system_name']],
                $type
            );
        }
    }
}
