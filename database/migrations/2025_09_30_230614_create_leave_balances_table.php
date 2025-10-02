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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('special_leave_type_id')->constrained()->onDelete('cascade');
            $table->year('year')->comment('Année du solde');
            $table->integer('initial_balance')->default(0)->comment('Solde initial en début d\'année');
            $table->integer('current_balance')->default(0)->comment('Solde actuel disponible');
            $table->integer('used_balance')->default(0)->comment('Solde utilisé');
            $table->integer('adjustment_balance')->default(0)->comment('Ajustements manuels (positifs ou négatifs)');
            $table->text('notes')->nullable()->comment('Notes sur les ajustements ou particularités');
            $table->timestamps();

            // Index composé pour éviter les doublons et optimiser les requêtes
            $table->unique(['user_id', 'special_leave_type_id', 'year'], 'unique_user_leave_type_year');
            
            // Index pour les requêtes fréquentes
            $table->index(['user_id', 'year']);
            $table->index(['special_leave_type_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
