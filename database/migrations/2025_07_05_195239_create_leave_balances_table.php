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
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->integer('annual_leave_days')->default(25);
            $table->integer('sick_leave_days')->default(12);
            $table->integer('maternity_leave_days')->default(90);
            $table->integer('paternity_leave_days')->default(14);
            $table->integer('special_leave_days')->default(5);
            $table->boolean('is_default')->default(false);
            $table->string('description')->nullable();
            $table->timestamps();
            
            $table->index(['company_id', 'is_default']);
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
