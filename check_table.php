<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "=== Vérification de la table attestation_requests ===\n";
    
    // Vérifier si la table existe
    if (Schema::hasTable('attestation_requests')) {
        echo "✓ La table 'attestation_requests' existe\n\n";
        
        // Obtenir la structure de la table
        echo "=== Structure de la table ===\n";
        $columns = DB::select('DESCRIBE attestation_requests');
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type}) - {$column->Null} - {$column->Key}\n";
        }
        
        echo "\n=== Nombre d'enregistrements ===\n";
        $count = DB::table('attestation_requests')->count();
        echo "Nombre total d'enregistrements: {$count}\n";
        
        if ($count > 0) {
            echo "\n=== Derniers enregistrements ===\n";
            $recent = DB::table('attestation_requests')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            foreach ($recent as $record) {
                echo "ID: {$record->id}, User: {$record->user_id}, Type: {$record->attestation_type_id}, Status: {$record->status}, Created: {$record->created_at}\n";
            }
        }
        
    } else {
        echo "✗ La table 'attestation_requests' n'existe PAS\n";
        echo "\n=== Tables disponibles ===\n";
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- {$tableName}\n";
        }
    }
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}