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
            // D'abord, ajouter les nouvelles colonnes
            $table->string('last_name')->after('name');
            $table->string('phone')->after('email')->nullable();
        });

        // Ensuite, renommer la colonne name en first_name
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // D'abord, restaurer le nom de la colonne
            $table->renameColumn('first_name', 'name');
        });

        Schema::table('users', function (Blueprint $table) {
            // Ensuite, supprimer les colonnes ajoutées
            $table->dropColumn(['last_name', 'phone']);
        });
    }
};