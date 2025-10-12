<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\ContractType;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->warn("Aucune société trouvée. Veuillez créer la société avant de seed les types de contrat.");
            return;
        }

        $types = [
            [
                'name' => 'CDI',
                'description' => 'Contrat à durée indéterminée',
                'is_active' => true,
            ],
            [
                'name' => 'CDD',
                'description' => 'Contrat à durée déterminée',
                'is_active' => true,
            ],
            [
                'name' => 'Interim',
                'description' => 'Contrat d\'intérim',
                'is_active' => true,
            ],
            [
                'name' => 'Stage',
                'description' => 'Contrat de stage',
                'is_active' => true,
            ],
            [
                'name' => 'Alternance',
                'description' => 'Contrat en alternance',
                'is_active' => true,
            ],
            [
                'name' => 'Freelance',
                'description' => 'Contrat indépendant / prestataire',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            $name = $type['name'];
            $systemName = ContractType::generateSystemName($name, $company->id);

            ContractType::updateOrCreate(
                [
                    'company_id' => $company->id,
                    'system_name' => $systemName,
                ],
                [
                    'name' => $name,
                    'description' => $type['description'] ?? null,
                    'is_active' => $type['is_active'] ?? true,
                ]
            );

            $this->command->info("Type de contrat créé/trouvé: {$name} ({$systemName})");
        }
    }
}