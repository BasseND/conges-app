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
        Schema::table('leaves', function (Blueprint $table) {
            $table->unsignedBigInteger('cancelled_by')->nullable()->after('approved_by');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
            
            // Index pour les requêtes de recherche
            $table->index('cancelled_by');
            
            // Clé étrangère pour cancelled_by
            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by']);
            $table->dropIndex(['cancelled_by']);
            $table->dropColumn(['cancelled_by', 'cancelled_at', 'cancellation_reason']);
        });
    }
};
