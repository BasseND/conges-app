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
            // Vérifier si la colonne n'existe pas déjà
            if (!Schema::hasColumn('attestation_requests', 'generated_by')) {
                $table->unsignedBigInteger('generated_by')->nullable()->after('processed_by');
                $table->foreign('generated_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestation_requests', function (Blueprint $table) {
            if (Schema::hasColumn('attestation_requests', 'generated_by')) {
                $table->dropForeign(['generated_by']);
                $table->dropColumn('generated_by');
            }
        });
    }
};