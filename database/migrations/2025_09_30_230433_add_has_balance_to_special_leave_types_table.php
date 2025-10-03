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
            $table->boolean('has_balance')->default(true)->after('is_active')
                ->comment('Indique si ce type de congé a un solde limité (true) ou est illimité (false)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('special_leave_types', function (Blueprint $table) {
            $table->dropColumn('has_balance');
        });
    }
};
