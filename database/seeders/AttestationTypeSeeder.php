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
                'description' => 'Attestation confirmant l\'emploi du salarié dans l\'entreprise',
                'template_file' => 'attestation_travail',
                'type' => 'employment',
                'status' => 'active',
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Attestation de salaire',
                'description' => 'Attestation indiquant le salaire et les conditions d\'emploi',
                'template_file' => 'attestation_salaire',
                'type' => 'salary',
                'status' => 'active',
                'requires_salary_info' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'name' => 'Attestation de stage',
                'description' => 'Attestation pour les stagiaires',
                'template_file' => 'attestation_stage',
                'type' => 'custom',
                'status' => 'active',
                'requires_date_range' => true,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($types as $type) {
            AttestationType::create($type);
        }
    }
}
