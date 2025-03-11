<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contract;
use Carbon\Carbon;

class UpdateExpiredContracts extends Command
{
    protected $signature = 'contracts:update-expired';
    protected $description = 'Met à jour le statut is_expired des contrats dont la date de fin est passée';

    public function handle()
    {
        $today = Carbon::today();
        
        // Mettre à jour tous les contrats expirés qui ne sont pas encore marqués comme tels
        $updatedCount = Contract::where('date_fin', '<', $today)
            ->where('is_expired', false)
            ->update(['is_expired' => true]);
        
        $this->info("$updatedCount contrats ont été marqués comme expirés.");
        
        return Command::SUCCESS;
    }
}