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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Ajouter la colonne team_id à la table users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
        Schema::dropIfExists('teams');
    }
};
