<?php

namespace App\Jobs;

use App\Imports\UsersImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessUsersImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;
    
    /**
     * The number of seconds the job can run before timing out.
     */
    public $timeout = 600; // 10 minutes

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Début de l\'import d\'utilisateurs en arrière-plan', [
                'file' => $this->filePath,
                'user_id' => $this->userId
            ]);
            
            $import = new UsersImport();
            Excel::import($import, Storage::path($this->filePath));
            
            $successCount = $import->getSuccessCount();
            $errorCount = $import->getErrorCount();
            $errors = $import->getErrors();
            
            Log::info('Import d\'utilisateurs terminé', [
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'user_id' => $this->userId
            ]);
            
            // Nettoyer le fichier temporaire
            Storage::delete($this->filePath);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'import d\'utilisateurs en arrière-plan', [
                'error' => $e->getMessage(),
                'file' => $this->filePath,
                'user_id' => $this->userId
            ]);
            
            // Nettoyer le fichier temporaire même en cas d'erreur
            Storage::delete($this->filePath);
            
            throw $e;
        }
    }
}
