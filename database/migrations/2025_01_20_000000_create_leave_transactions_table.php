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
        Schema::create('leave_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('leave_type', ['annual', 'sick', 'maternity', 'paternity', 'special']);
            $table->enum('transaction_type', ['allocation', 'deduction', 'adjustment', 'reset']);
            $table->decimal('amount', 8, 2); // Peut être positif ou négatif
            $table->decimal('balance_before', 8, 2);
            $table->decimal('balance_after', 8, 2);
            $table->string('description')->nullable();
            $table->json('metadata')->nullable(); // Pour stocker des informations supplémentaires
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['user_id', 'leave_type']);
            $table->index(['user_id', 'created_at']);
            $table->index('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_transactions');
    }
};