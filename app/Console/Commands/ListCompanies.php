<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;

class ListCompanies extends Command
{
    protected $signature = 'list:companies';
    protected $description = 'Liste toutes les entreprises disponibles';

    public function handle()
    {
        $companies = Company::all(['id', 'name']);
        
        if ($companies->isEmpty()) {
            $this->info('Aucune entreprise trouvée.');
            return;
        }
        
        $this->info('Entreprises disponibles:');
        foreach ($companies as $company) {
            $this->line("ID: {$company->id}, Nom: {$company->name}");
        }
        
        $this->info("Total: {$companies->count()} entreprise(s)");
    }
}