<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiagnoseDepartmentIssue extends Command
{
    protected $signature = 'diagnose:department-issue';
    protected $description = 'Diagnostic complet des problèmes de mise à jour des départements';

    public function handle()
    {
        $this->info('=== DIAGNOSTIC DES DÉPARTEMENTS ===');
        
        // 1. Vérifier la structure de la table departments
        $this->info('\n1. Structure de la table departments:');
        $columns = Schema::getColumnListing('departments');
        $this->table(['Colonnes'], array_map(fn($col) => [$col], $columns));
        
        // 2. Vérifier les départements existants
        $this->info('\n2. Départements existants:');
        $departments = Department::all();
        if ($departments->count() > 0) {
            $this->table(
                ['ID', 'Nom', 'Code', 'Head ID', 'Chef'],
                $departments->map(function($dept) {
                    return [
                        $dept->id,
                        $dept->name,
                        $dept->code,
                        $dept->head_id ?? 'NULL',
                        $dept->head ? $dept->head->first_name . ' ' . $dept->head->last_name : 'Aucun'
                    ];
                })->toArray()
            );
        } else {
            $this->warn('Aucun département trouvé');
        }
        
        // 3. Vérifier les chefs de département disponibles
        $this->info('\n3. Chefs de département disponibles:');
        $heads = User::where('role', User::ROLE_DEPARTMENT_HEAD)->get();
        if ($heads->count() > 0) {
            $this->table(
                ['ID', 'Nom', 'Email', 'Department ID', 'Disponible'],
                $heads->map(function($user) {
                    // Un chef est disponible s'il n'a pas de département assigné comme chef
                    $isAvailable = !$user->departmentAsHead ? 'Oui' : 'Non';
                    return [
                        $user->id,
                        $user->first_name . ' ' . $user->last_name,
                        $user->email,
                        $user->department_id ?? 'NULL',
                        $isAvailable
                    ];
                })->toArray()
            );
            
            // Compter les chefs disponibles
            $availableHeads = User::where('role', User::ROLE_DEPARTMENT_HEAD)
                ->whereDoesntHave('departmentAsHead')
                ->count();
            $this->info("Nombre de chefs disponibles: {$availableHeads}");
        } else {
            $this->warn('Aucun chef de département trouvé');
        }
        
        // 4. Tester la mise à jour d'un département
        $this->info('\n4. Test de mise à jour:');
        
        $testDepartment = Department::first();
        $availableHead = User::where('role', User::ROLE_DEPARTMENT_HEAD)
            ->whereDoesntHave('departmentAsHead')
            ->first();
        
        if ($testDepartment && $availableHead) {
            try {
                $oldHeadId = $testDepartment->head_id;
                
                // Désassigner l'ancien chef s'il existe
                if ($oldHeadId) {
                    $oldHead = User::find($oldHeadId);
                    if ($oldHead) {
                        $this->info("Désassignation de l'ancien chef: {$oldHead->first_name} {$oldHead->last_name}");
                    }
                }
                
                // Assigner le nouveau chef
                $testDepartment->head_id = $availableHead->id;
                $testDepartment->save();
                
                $this->info("✅ Test réussi: Département '{$testDepartment->name}' mis à jour avec le chef '{$availableHead->first_name} {$availableHead->last_name}'");
                
                // Restaurer l'état original
                $testDepartment->head_id = $oldHeadId;
                $testDepartment->save();
                
                if ($oldHeadId) {
                    $this->info("État original restauré");
                }
                
            } catch (\Exception $e) {
                $this->error('❌ Erreur lors du test: ' . $e->getMessage());
            }
        } else {
            $this->warn('Impossible de faire le test: département ou chef disponible manquant');
            if (!$testDepartment) {
                $this->warn('- Aucun département trouvé');
            }
            if (!$availableHead) {
                $this->warn('- Aucun chef disponible trouvé');
            }
        }
        
        // 5. Vérifier les contraintes de base de données
        $this->info('\n5. Contraintes de clés étrangères:');
        try {
            $constraints = DB::select("SELECT 
                CONSTRAINT_NAME,
                TABLE_NAME,
                COLUMN_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'departments' 
            AND REFERENCED_TABLE_NAME IS NOT NULL");
            
            if (count($constraints) > 0) {
                $this->table(
                    ['Contrainte', 'Table', 'Colonne', 'Table référencée', 'Colonne référencée'],
                    array_map(function($constraint) {
                        return [
                            $constraint->CONSTRAINT_NAME,
                            $constraint->TABLE_NAME,
                            $constraint->COLUMN_NAME,
                            $constraint->REFERENCED_TABLE_NAME,
                            $constraint->REFERENCED_COLUMN_NAME
                        ];
                    }, $constraints)
                );
            } else {
                $this->warn('Aucune contrainte de clé étrangère trouvée');
            }
        } catch (\Exception $e) {
            $this->error('Erreur lors de la vérification des contraintes: ' . $e->getMessage());
        }
        
        $this->info('\n=== FIN DU DIAGNOSTIC ===');
    }
}