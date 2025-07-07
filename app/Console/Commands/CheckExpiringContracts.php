<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckExpiringContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:check-expiring {--days=30 : Number of days before expiration to notify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for contracts that are expiring soon and send notifications';

    protected NotificationService $notificationService;

    /**
     * Create a new command instance.
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $expirationDate = Carbon::now()->addDays($days);
        
        $this->info("Checking for contracts expiring within {$days} days...");
        
        // Rechercher les utilisateurs dont le contrat expire bientôt
        $expiringUsers = User::whereNotNull('contract_end_date')
            ->where('contract_end_date', '<=', $expirationDate)
            ->where('contract_end_date', '>=', Carbon::now())
            ->get();
        
        if ($expiringUsers->isEmpty()) {
            $this->info('No expiring contracts found.');
            return self::SUCCESS;
        }
        
        $this->info("Found {$expiringUsers->count()} expiring contracts.");
        
        foreach ($expiringUsers as $user) {
            $this->notificationService->createContractExpiringNotification($user);
            $this->line("Notification created for {$user->name} (expires: {$user->contract_end_date->format('d/m/Y')})");
        }
        
        $this->info('Contract expiration notifications sent successfully.');
        
        return self::SUCCESS;
    }
}