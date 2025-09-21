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
        Schema::create('special_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom du type de congé (ex: Césarienne, Mariage, etc.)
            $table->integer('duration_days')->default(0); // Nombre de jours (0 pour variable)
            $table->text('description')->nullable(); // Description optionnelle
            $table->boolean('is_active')->default(true); // Actif/Inactif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_leave_types');
    }
};
