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
        // Modifier l'enum pour ajouter 'maternity' et 'paternity'
        DB::statement("ALTER TABLE leaves MODIFY COLUMN type ENUM('annual', 'sick', 'unpaid', 'other', 'maternity', 'paternity')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à l'enum précédent
        DB::statement("ALTER TABLE leaves MODIFY COLUMN type ENUM('annual', 'sick', 'unpaid', 'other')");
    }
};