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
            $table->integer('seniority_months')->default(0)->after('duration_days')->comment('Nombre de mois d\'ancienneté requis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_leave_types', function (Blueprint $table) {
            $table->dropColumn('seniority_months');
        });
    }
};
