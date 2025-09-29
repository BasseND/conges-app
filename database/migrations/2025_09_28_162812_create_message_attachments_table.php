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
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->onDelete('cascade');
            $table->string('original_name'); // Nom original du fichier
            $table->string('file_name'); // Nom du fichier stocké
            $table->string('file_path'); // Chemin du fichier
            $table->string('mime_type'); // Type MIME du fichier
            $table->unsignedBigInteger('file_size'); // Taille du fichier en bytes
            $table->string('file_extension'); // Extension du fichier
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index('message_id');
            $table->index('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_attachments');
    }
};
