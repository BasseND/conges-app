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
        // Sauvegarder les rôles actuels
        $users = DB::table('users')->select('id', 'role')->get();
        
        Schema::table('users', function (Blueprint $table) {
            // Supprimer l'ancienne colonne
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Créer la nouvelle colonne avec une plus grande taille
            $table->string('role', 20)->after('password');
        });

        // Restaurer les rôles
        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role' => $user->role]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Sauvegarder les rôles actuels
        $users = DB::table('users')->select('id', 'role')->get();
        
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la nouvelle colonne
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Recréer l'ancienne colonne
            $table->string('role', 10)->after('password');
        });

        // Restaurer les rôles
        foreach ($users as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role' => $user->role]);
        }
    }
};
