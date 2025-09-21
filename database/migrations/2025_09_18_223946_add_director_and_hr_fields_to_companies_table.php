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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('director_name')->nullable()->after('name');
            $table->string('hr_director_name')->nullable()->after('director_name');
            $table->string('hr_signature')->nullable()->after('hr_director_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['director_name', 'hr_director_name', 'hr_signature']);
        });
    }
};
