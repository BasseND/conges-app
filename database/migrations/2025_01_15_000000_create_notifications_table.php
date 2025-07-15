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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Type de notification (leave_request, expense_report, user_created, etc.)
            $table->string('title'); // Titre de la notification
            $table->text('message'); // Message de la notification
            $table->json('data')->nullable(); // Données supplémentaires (IDs, liens, etc.)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur concerné
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Qui a créé la notification
            $table->boolean('is_read')->default(false); // Lu ou non
            $table->timestamp('read_at')->nullable(); // Date de lecture
            $table->string('priority')->default('normal'); // Priorité (low, normal, high, urgent)
            $table->string('category')->nullable(); // Catégorie (leave, expense, contract, user)
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['type', 'created_at']);
            $table->index(['category', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};