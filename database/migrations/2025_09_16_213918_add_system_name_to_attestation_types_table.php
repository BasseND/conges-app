<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si la colonne n'existe pas déjà
        if (!Schema::hasColumn('attestation_types', 'system_name')) {
            Schema::table('attestation_types', function (Blueprint $table) {
                $table->string('system_name')->nullable()->after('name')->unique();
            });
        }
        
        // Mettre à jour les enregistrements existants avec des system_name uniques
        $types = DB::table('attestation_types')->whereNull('system_name')->get();
        $usedSystemNames = [];
        
        foreach ($types as $type) {
            $baseSystemName = strtolower(str_replace([' ', '-', "'"], '_', $type->name));
            $systemName = $baseSystemName;
            $counter = 1;
            
            // Vérifier si le system_name existe déjà
            while (in_array($systemName, $usedSystemNames) || 
                   DB::table('attestation_types')->where('system_name', $systemName)->exists()) {
                $systemName = $baseSystemName . '_' . $counter;
                $counter++;
            }
            
            $usedSystemNames[] = $systemName;
            DB::table('attestation_types')
                ->where('id', $type->id)
                ->update(['system_name' => $systemName]);
        }
        
        // Rendre le champ obligatoire après la mise à jour
        Schema::table('attestation_types', function (Blueprint $table) {
            $table->string('system_name')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestation_types', function (Blueprint $table) {
            $table->dropColumn('system_name');
        });
    }
};
