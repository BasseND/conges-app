<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // D'abord, mettre à jour les valeurs NULL avec des valeurs par défaut
        $usersWithoutMatricule = DB::table('users')->whereNull('matricule')->get();
        foreach ($usersWithoutMatricule as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['matricule' => 'MAT' . str_pad($user->id, 6, '0', STR_PAD_LEFT)]);
        }
        
        DB::table('users')
            ->whereNull('marital_status')
            ->update(['marital_status' => 'célibataire']);
        
        DB::table('users')
            ->whereNull('category')
            ->update(['category' => 'employe']);
        
        DB::table('users')
            ->whereNull('birth_date')
            ->update(['birth_date' => '1990-01-01']);
        
        DB::table('users')
            ->whereNull('address')
            ->update(['address' => 'Adresse non renseignée']);
        
        DB::table('users')
            ->whereNull('entry_date')
            ->update(['entry_date' => now()->format('Y-m-d')]);

        // Ensuite, rendre les champs obligatoires (non-nullable)
        Schema::table('users', function (Blueprint $table) {
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
