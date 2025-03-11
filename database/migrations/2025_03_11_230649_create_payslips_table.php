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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->constrained('contrats')->onDelete('cascade');
            $table->unsignedTinyInteger('period_month');
            $table->unsignedSmallInteger('period_year');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('gross_salary', 10, 2);
            $table->decimal('net_salary', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('bonus_amount', 10, 2)->default(0);
            $table->decimal('expense_reimbursement', 10, 2)->default(0);
            $table->string('status')->default('draft');
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            // Contrainte d'unicité pour éviter les doublons pour un même mois/année/utilisateur
            $table->unique(['user_id', 'period_month', 'period_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
