<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('head_id')->nullable()->constrained('users')->nullOnDelete();
        });

        // Supprimer d'abord la contrainte de clé étrangère
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });
    }

    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
            $table->dropColumn('head_id');
        });
    }
};
