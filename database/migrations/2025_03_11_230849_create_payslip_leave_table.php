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
        Schema::create('payslip_leave', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payslip_id')->constrained()->onDelete('cascade');
            $table->foreignId('leave_id')->constrained()->onDelete('cascade');
            $table->decimal('impact_amount', 10, 2)->default(0);
            $table->timestamps();

            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['payslip_id', 'leave_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslip_leave');
    }
};
