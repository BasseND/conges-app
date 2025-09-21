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
        // Convertir la colonne type de ENUM à VARCHAR pour supporter les types spéciaux
        DB::statement("ALTER TABLE leaves MODIFY COLUMN type VARCHAR(50) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'enum précédent
        DB::statement("ALTER TABLE leaves MODIFY COLUMN type ENUM('annual', 'sick', 'unpaid', 'other', 'maternity', 'paternity') NOT NULL");
    }
};
