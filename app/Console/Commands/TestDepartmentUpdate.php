<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;
use App\Models\User;

class TestDepartmentUpdate extends Command
{
    protected $signature = 'test:department-update';
    protected $description = 'Test department update functionality';

    public function handle()
    {
        $this->info('Testing department update functionality...');
        
        // Récupérer le premier département
        $department = Department::first();
        if (!$department) {
            $this->error('Aucun département trouvé');
            return;
        }
        
        $this->info("Département trouvé: {$department->name}");
        $this->info("Chef actuel: " . ($department->head_id ? $department->head->first_name . ' ' . $department->head->last_name : 'Aucun'));
        
        // Récupérer un chef de département disponible
        $availableHead = User::where('role', User::ROLE_DEPARTMENT_HEAD)
            ->where(function($query) use ($department) {
                $query->whereNull('department_id')
                    ->orWhere('department_id', $department->id);
            })
            ->first();
            
        if (!$availableHead) {
            $this->error('Aucun chef de département disponible');
            return;
        }
        
        $this->info("Chef disponible: {$availableHead->first_name} {$availableHead->last_name}");
        
        // Tester la mise à jour
        try {
            $oldHeadId = $department->head_id;
            
            // Mettre à jour le département
            $department->update(['head_id' => $availableHead->id]);
            
            // Gérer les changements de chef de département
            if ($oldHeadId != $availableHead->id) {
                // Retirer l'ancien chef du département s'il existe
                if ($oldHeadId) {
                    User::where('id', $oldHeadId)
                        ->update(['department_id' => null]);
                }
                
                // Assigner le nouveau chef au département
                User::where('id', $availableHead->id)
                    ->update(['department_id' => $department->id]);
            }
            
            $this->info('Mise à jour réussie!');
            
            // Vérifier le résultat
            $department->refresh();
            $this->info("Nouveau chef: {$department->head->first_name} {$department->head->last_name}");
            
        } catch (\Exception $e) {
            $this->error('Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }
}