<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AttestationType;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si des utilisateurs existent
        $userCount = User::count();
        
        if ($userCount > 0) {
            $adminUser = User::where('role', 'admin')->first();
            if (!$adminUser) {
                $adminUser = User::first();
            }

            // Vérifier si le type d'attestation n'existe pas déjà
            $existingType = AttestationType::where('system_name', 'attestation_de_presence')->first();
            
            if (!$existingType) {
                AttestationType::create([
                    'name' => 'Attestation de présence / assiduité',
                    'system_name' => 'attestation_de_presence',
                    'description' => 'Attestation confirmant la présence et l\'assiduité du salarié',
                    'template_file' => 'attestation_presence',
                    'type' => 'presence',
                    'status' => 'active',
                    'requires_date_range' => true,
                    'created_by' => $adminUser->id,
                ]);
            }
        }
        // Si aucun utilisateur n'existe, ignorer cette migration pour l'instant
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        AttestationType::where('system_name', 'attestation_de_presence')->delete();
    }
};
