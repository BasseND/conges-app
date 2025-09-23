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
        Schema::table('contract_types', function (Blueprint $table) {
            $table->string('system_name')->after('name')->nullable();
            
            // Index unique pour éviter les doublons de system_name par société
            $table->unique(['company_id', 'system_name'], 'contract_types_company_system_name_unique');
            
            // Index unique pour éviter les doublons de nom par société
            $table->unique(['company_id', 'name'], 'contract_types_company_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_types', function (Blueprint $table) {
            $table->dropUnique('contract_types_company_system_name_unique');
            $table->dropUnique('contract_types_company_name_unique');
            $table->dropColumn('system_name');
        });
    }
};
