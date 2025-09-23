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
        Schema::table('users', function (Blueprint $table) {
            // Rendre les champs obligatoires (non-nullable)
            $table->string('matricule')->nullable(false)->change();
            $table->enum('marital_status', ['marié', 'célibataire', 'veuf'])->nullable(false)->change();
            $table->enum('category', ['cadre', 'agent_de_maitrise', 'employe', 'ouvrier'])->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->date('entry_date')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remettre les champs comme nullable
            $table->string('matricule')->nullable()->change();
            $table->enum('marital_status', ['marié', 'célibataire', 'veuf'])->nullable()->change();
            $table->enum('category', ['cadre', 'agent_de_maitrise', 'employe', 'ouvrier'])->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->date('entry_date')->nullable()->change();
        });
    }
};
