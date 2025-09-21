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
        Schema::create('attestation_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du type d'attestation
            $table->text('description')->nullable(); // Description du type
            $table->longText('template_content'); // Contenu du template HTML/PDF
            $table->enum('type', ['salary', 'presence', 'employment', 'custom'])->default('custom'); // Type prédéfini
            $table->enum('status', ['active', 'inactive'])->default('active'); // Statut actif/inactif
            $table->boolean('requires_date_range')->default(false); // Nécessite une plage de dates
            $table->boolean('requires_salary_info')->default(false); // Nécessite les infos de salaire
            $table->boolean('requires_custom_fields')->default(false); // Nécessite des champs personnalisés
            $table->json('custom_fields_config')->nullable(); // Configuration des champs personnalisés
            $table->foreignId('created_by')->constrained('users'); // Utilisateur créateur
            $table->foreignId('updated_by')->nullable()->constrained('users'); // Utilisateur modificateur
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attestation_types');
    }
};
