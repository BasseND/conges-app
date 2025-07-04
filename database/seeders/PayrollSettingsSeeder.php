<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayrollSetting;
use Carbon\Carbon;

class PayrollSettingsSeeder extends Seeder
{
    /**
     * Exécute le seeder pour créer les paramètres de paie français.
     *
     * @return void
     */
    public function run()
    {
        // Supprimer les paramètres existants pour éviter les doublons
        PayrollSetting::truncate();

        // Année courante
        $currentYear = Carbon::now()->year;
        $validFrom = Carbon::create($currentYear, 1, 1);
        
        // Paramètres de cotisations salariales (part salarié)
        $this->createContributions();
        
        // Paramètres de charges patronales (part employeur)
        $this->createEmployerContributions();
        
        // Paramètres de seuils et plafonds
        $this->createThresholds();
        
        // Taux d'imposition
        $this->createTaxRates();
    }

    /**
     * Crée les cotisations salariales
     */
    private function createContributions()
    {
        $contributions = [
            [
                'name' => 'Sécurité sociale - Maladie',
                'value' => 0.00,
                'description' => 'Cotisation d\'assurance maladie',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'Sécurité sociale - Vieillesse plafonnée',
                'value' => 6.90,
                'description' => 'Cotisation d\'assurance vieillesse plafonnée',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'Sécurité sociale - Vieillesse déplafonnée',
                'value' => 0.40,
                'description' => 'Cotisation d\'assurance vieillesse déplafonnée',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'Assurance chômage',
                'value' => 0.00,
                'description' => 'Cotisation d\'assurance chômage',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'Retraite complémentaire (AGIRC-ARRCO) T1',
                'value' => 3.15,
                'description' => 'Cotisation de retraite complémentaire tranche 1',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'Retraite complémentaire (AGIRC-ARRCO) T2',
                'value' => 8.64,
                'description' => 'Cotisation de retraite complémentaire tranche 2',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'CEG T1',
                'value' => 0.86,
                'description' => 'Contribution d\'équilibre général tranche 1',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'CEG T2',
                'value' => 1.08,
                'description' => 'Contribution d\'équilibre général tranche 2',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'CSG déductible',
                'value' => 6.80,
                'description' => 'Contribution sociale généralisée déductible',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
            [
                'name' => 'CSG/CRDS non déductible',
                'value' => 2.90,
                'description' => 'CSG et CRDS non déductibles des impôts',
                'type' => PayrollSetting::TYPE_CONTRIBUTION,
                'is_percentage' => true,
            ],
        ];

        foreach ($contributions as $contribution) {
            PayrollSetting::create(array_merge($contribution, [
                'is_active' => true,
                'applies_to' => 'all',
                'valid_from' => Carbon::now()->startOfYear(),
            ]));
        }
    }

    /**
     * Crée les charges patronales
     */
    private function createEmployerContributions()
    {
        $employerContributions = [
            [
                'name' => 'Patronale - Sécurité sociale - Maladie',
                'value' => 7.00,
                'description' => 'Cotisation patronale d\'assurance maladie',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Sécurité sociale - Vieillesse plafonnée',
                'value' => 8.55,
                'description' => 'Cotisation patronale d\'assurance vieillesse plafonnée',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Sécurité sociale - Vieillesse déplafonnée',
                'value' => 1.90,
                'description' => 'Cotisation patronale d\'assurance vieillesse déplafonnée',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Allocations familiales',
                'value' => 3.45,
                'description' => 'Cotisation patronale d\'allocations familiales',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Accident du travail',
                'value' => 1.40,
                'description' => 'Cotisation patronale d\'accident du travail (taux moyen)',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Assurance chômage',
                'value' => 4.05,
                'description' => 'Cotisation patronale d\'assurance chômage',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - AGS (garantie des salaires)',
                'value' => 0.15,
                'description' => 'Association pour la gestion du régime de garantie des créances des salariés',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Retraite complémentaire (AGIRC-ARRCO) T1',
                'value' => 4.72,
                'description' => 'Cotisation patronale de retraite complémentaire tranche 1',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Retraite complémentaire (AGIRC-ARRCO) T2',
                'value' => 12.95,
                'description' => 'Cotisation patronale de retraite complémentaire tranche 2',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - CEG T1',
                'value' => 1.29,
                'description' => 'Contribution patronale d\'équilibre général tranche 1',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - CEG T2',
                'value' => 1.62,
                'description' => 'Contribution patronale d\'équilibre général tranche 2',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Forfait social',
                'value' => 8.00,
                'description' => 'Forfait social sur certaines sommes (participation, intéressement...)',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - Versement mobilité',
                'value' => 2.00,
                'description' => 'Contribution au financement des transports en commun (varie selon les régions)',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
            [
                'name' => 'Patronale - FNAL',
                'value' => 0.50,
                'description' => 'Fonds national d\'aide au logement',
                'type' => PayrollSetting::TYPE_TAX,
                'is_percentage' => true,
            ],
        ];

        foreach ($employerContributions as $contribution) {
            PayrollSetting::create(array_merge($contribution, [
                'is_active' => true,
                'applies_to' => 'all',
                'valid_from' => Carbon::now()->startOfYear(),
            ]));
        }
    }

    /**
     * Crée les seuils et plafonds
     */
    private function createThresholds()
    {
        $thresholds = [
            [
                'name' => 'PMSS',
                'value' => 3666.00,
                'description' => 'Plafond Mensuel de la Sécurité Sociale pour ' . Carbon::now()->year,
                'type' => PayrollSetting::TYPE_THRESHOLD,
                'is_percentage' => false,
            ],
            [
                'name' => 'SMIC Mensuel',
                'value' => 1766.92,
                'description' => 'SMIC mensuel brut pour ' . Carbon::now()->year . ' (base 35h/semaine)',
                'type' => PayrollSetting::TYPE_THRESHOLD,
                'is_percentage' => false,
            ],
            [
                'name' => 'SMIC Horaire',
                'value' => 11.65,
                'description' => 'SMIC horaire brut pour ' . Carbon::now()->year,
                'type' => PayrollSetting::TYPE_THRESHOLD,
                'is_percentage' => false,
            ],
            [
                'name' => 'Plafond T1 AGIRC-ARRCO',
                'value' => 3666.00,
                'description' => 'Plafond de la tranche 1 pour les cotisations AGIRC-ARRCO',
                'type' => PayrollSetting::TYPE_THRESHOLD,
                'is_percentage' => false,
            ],
            [
                'name' => 'Plafond T2 AGIRC-ARRCO',
                'value' => 29328.00,
                'description' => 'Plafond de la tranche 2 pour les cotisations AGIRC-ARRCO (8 PMSS)',
                'type' => PayrollSetting::TYPE_THRESHOLD,
                'is_percentage' => false,
            ],
        ];

        foreach ($thresholds as $threshold) {
            PayrollSetting::create(array_merge($threshold, [
                'is_active' => true,
                'applies_to' => 'all',
                'valid_from' => Carbon::now()->startOfYear(),
            ]));
        }
    }

    /**
     * Crée les taux d'imposition
     */
    private function createTaxRates()
    {
        $taxRates = [
            [
                'name' => 'Taux de prélèvement à la source - Neutre',
                'value' => 7.50,
                'description' => 'Taux non personnalisé pour le prélèvement à la source (taux neutre)',
                'type' => PayrollSetting::TYPE_RATE,
                'is_percentage' => true,
            ],
        ];

        foreach ($taxRates as $rate) {
            PayrollSetting::create(array_merge($rate, [
                'is_active' => true,
                'applies_to' => 'all',
                'valid_from' => Carbon::now()->startOfYear(),
            ]));
        }
    }
}
