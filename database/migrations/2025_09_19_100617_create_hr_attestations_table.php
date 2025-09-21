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
        Schema::create('hr_attestations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('attestation_type_id')->constrained('attestation_types')->onDelete('cascade');
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->string('document_number')->unique();
            $table->enum('status', ['draft', 'generated', 'sent', 'archived'])->default('draft');
            $table->string('pdf_path')->nullable();
            $table->json('data')->nullable(); // Stockage des données du formulaire
            $table->timestamp('generated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index(['employee_id', 'attestation_type_id']);
            $table->index(['status', 'generated_at']);
            $table->index('document_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_attestations');
    }
};
