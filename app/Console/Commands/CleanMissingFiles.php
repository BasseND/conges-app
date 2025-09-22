<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CleanMissingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clean-missing {--dry-run : Show what would be cleaned without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean missing file references from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('Mode simulation - Aucune modification ne sera effectuée');
        }
        
        $this->info('Nettoyage des références de fichiers inexistants...');
        
        $companies = Company::whereNotNull('logo')
            ->orWhereNotNull('hr_signature')
            ->get();
            
        $cleanedCount = 0;
        
        foreach ($companies as $company) {
            $updated = false;
            
            // Vérifier le logo
            if ($company->logo && !Storage::disk('public')->exists($company->logo)) {
                $this->warn("Logo manquant pour {$company->name}: {$company->logo}");
                if (!$dryRun) {
                    $company->logo = null;
                    $updated = true;
                }
            }
            
            // Vérifier la signature
            if ($company->hr_signature && !Storage::disk('public')->exists($company->hr_signature)) {
                $this->warn("Signature manquante pour {$company->name}: {$company->hr_signature}");
                if (!$dryRun) {
                    $company->hr_signature = null;
                    $updated = true;
                }
            }
            
            if ($updated) {
                $company->save();
                $cleanedCount++;
                $this->info("✓ {$company->name} mis à jour");
            }
        }
        
        if ($dryRun) {
            $this->info("Simulation terminée. {$cleanedCount} entreprises seraient nettoyées.");
            $this->info('Exécutez sans --dry-run pour appliquer les changements.');
        } else {
            $this->info("Nettoyage terminé. {$cleanedCount} entreprises mises à jour.");
        }
        
        return 0;
    }
}