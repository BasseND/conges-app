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
        Schema::table('attestation_types', function (Blueprint $table) {
            $table->string('template_file')->nullable()->after('template_content')
                  ->comment('Nom du fichier template HTML à utiliser pour générer l\'attestation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attestation_types', function (Blueprint $table) {
            $table->dropColumn('template_file');
        });
    }
};
