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
            // Ajouter les champs manquants de hr_attestations
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null')->after('processed_by');
            $table->string('document_number')->nullable()->unique()->after('id');
            $table->timestamp('sent_at')->nullable()->after('generated_at');
            $table->timestamp('archived_at')->nullable()->after('sent_at');
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'attestation_type_id']);
            $table->index(['status', 'generated_at']);
            $table->index('document_number');
        });
        
        // Modifier la colonne status pour inclure les nouveaux statuts
        Schema::table('attestation_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'generated', 'draft', 'sent', 'archived'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestation_requests', function (Blueprint $table) {
            $table->dropForeign(['generated_by']);
            $table->dropIndex(['user_id', 'attestation_type_id']);
            $table->dropIndex(['status', 'generated_at']);
            $table->dropIndex(['document_number']);
            $table->dropColumn(['generated_by', 'document_number', 'sent_at', 'archived_at']);
        });
        
        // Remettre l'ancien enum status
        Schema::table('attestation_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'generated'])
                  ->default('pending')
                  ->change();
        });
    }
};