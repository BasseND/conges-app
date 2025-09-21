<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('special_leave_types', function (Blueprint $table) {
            $table->string('system_name')->nullable()->after('name')->unique();
        });
        
        // Mettre à jour les enregistrements existants
        DB::statement("UPDATE special_leave_types SET system_name = LOWER(REPLACE(REPLACE(REPLACE(name, ' ', '_'), '-', '_'), '\'', '')) WHERE system_name IS NULL");
        
        // Rendre le champ obligatoire après la mise à jour
        Schema::table('special_leave_types', function (Blueprint $table) {
            $table->string('system_name')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_leave_types', function (Blueprint $table) {
            $table->dropColumn('system_name');
        });
    }
};