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
            // Civilité
            $table->enum('marital_status', ['marié', 'célibataire', 'veuf'])->nullable()->after('gender');
            
            // Statut professionnel
            $table->enum('employment_status', ['fonctionnaire', 'contractuel_cdi', 'contractuel_cdd'])->nullable()->after('marital_status');
            
            // Nombre d'enfants à charge
            $table->unsignedInteger('children_count')->default(0)->after('employment_status');
            
            // Matricule
            $table->string('matricule')->unique()->nullable()->after('employee_id');
            
            // Affectation
            $table->string('affectation')->nullable()->after('matricule');
            
            // Catégorie
            $table->enum('category', ['cadre', 'agent_de_maitrise', 'employe', 'ouvrier'])->nullable()->after('affectation');
            
            // Section
            $table->string('section')->nullable()->after('category');
            
            // Service
            $table->string('service')->nullable()->after('section');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'employment_status', 
                'children_count',
                'matricule',
                'affectation',
                'category',
                'section',
                'service'
            ]);
        });
    }
};
