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
        Schema::create('leave_balance_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_balance_id')->constrained()->onDelete('cascade');
            $table->foreignId('adjusted_by')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 8, 2); // Montant de l'ajustement (peut être négatif)
            $table->string('reason')->nullable(); // Raison de l'ajustement
            $table->decimal('previous_balance', 8, 2); // Solde avant ajustement
            $table->decimal('new_balance', 8, 2); // Solde après ajustement
            $table->timestamps();

            $table->index(['leave_balance_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balance_adjustments');
    }
};
