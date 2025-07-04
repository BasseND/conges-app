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
        Schema::create('payroll_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 10, 4);
            $table->text('description')->nullable();
            $table->string('type');
            $table->boolean('is_percentage')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('applies_to')->default('all');
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();

            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['name', 'applies_to', 'valid_from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_settings');
    }
};
