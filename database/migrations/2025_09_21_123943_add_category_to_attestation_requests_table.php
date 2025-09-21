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
        Schema::table('attestation_requests', function (Blueprint $table) {
            $table->enum('category', ['hr_generated', 'employee_request'])
                  ->default('employee_request')
                  ->after('attestation_type_id')
                  ->comment('Catégorie: hr_generated pour les attestations générées par les RH, employee_request pour les demandes d\'employés');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestation_requests', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
