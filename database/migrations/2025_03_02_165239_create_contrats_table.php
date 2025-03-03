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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // CDI, CDD, stage, etc.
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // null si le contrat est en cours
            $table->decimal('salaire_brut', 10, 2);
            $table->string('statut')->default('actif'); // actif, terminé, suspendu, etc.
            // $table->string('motif_fin')->nullable(); // null si le contrat est en cours
            $table->string('contrat_file')->nullable(); // Contrat file (chemin/URL)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
