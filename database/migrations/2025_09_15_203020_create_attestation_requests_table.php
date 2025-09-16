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
        Schema::create('attestation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Utilisateur demandeur
            $table->foreignId('attestation_type_id')->constrained('attestation_types'); // Type d'attestation
            $table->enum('status', ['pending', 'approved', 'rejected', 'generated'])->default('pending'); // Statut de la demande
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal'); // Priorité
            $table->date('start_date')->nullable(); // Date de début (pour attestations avec période)
            $table->date('end_date')->nullable(); // Date de fin (pour attestations avec période)
            $table->json('custom_data')->nullable(); // Données personnalisées selon le type
            $table->text('notes')->nullable(); // Notes de l'employé
            $table->foreignId('processed_by')->nullable()->constrained('users'); // RH qui traite la demande
            $table->timestamp('processed_at')->nullable(); // Date de traitement
            $table->text('rejection_reason')->nullable(); // Raison du rejet
            $table->string('pdf_path')->nullable(); // Chemin vers le PDF généré
            $table->timestamp('generated_at')->nullable(); // Date de génération du PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attestation_requests');
    }
};
