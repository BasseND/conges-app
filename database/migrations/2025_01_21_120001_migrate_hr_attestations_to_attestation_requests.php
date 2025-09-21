<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrer les données de hr_attestations vers attestation_requests
        $hrAttestations = DB::table('hr_attestations')->get();
        
        foreach ($hrAttestations as $hrAttestation) {
            // Décoder les données JSON pour extraire start_date et end_date
            $data = json_decode($hrAttestation->data, true) ?? [];
            $startDate = $data['start_date'] ?? null;
            $endDate = $data['end_date'] ?? null;
            
            // Générer un numéro de document unique si pas déjà présent
            $documentNumber = $hrAttestation->document_number;
            
            // Mapper les statuts
            $status = match($hrAttestation->status) {
                'draft' => 'draft',
                'generated' => 'generated',
                'sent' => 'sent',
                'archived' => 'archived',
                default => 'generated'
            };
            
            // Insérer dans attestation_requests
            DB::table('attestation_requests')->insert([
                'user_id' => $hrAttestation->employee_id,
                'attestation_type_id' => $hrAttestation->attestation_type_id,
                'status' => $status,
                'priority' => 'normal', // Valeur par défaut
                'start_date' => $startDate,
                'end_date' => $endDate,
                'custom_data' => $hrAttestation->data, // Garder toutes les données originales
                'notes' => $hrAttestation->notes,
                'processed_by' => $hrAttestation->generated_by,
                'generated_by' => $hrAttestation->generated_by,
                'processed_at' => $hrAttestation->generated_at,
                'pdf_path' => $hrAttestation->pdf_path,
                'generated_at' => $hrAttestation->generated_at,
                'document_number' => $documentNumber,
                'sent_at' => $hrAttestation->status === 'sent' ? $hrAttestation->updated_at : null,
                'archived_at' => $hrAttestation->status === 'archived' ? $hrAttestation->updated_at : null,
                'created_at' => $hrAttestation->created_at,
                'updated_at' => $hrAttestation->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les enregistrements migrés depuis hr_attestations
        // On peut identifier ces enregistrements par leur document_number
        $hrDocumentNumbers = DB::table('hr_attestations')->pluck('document_number');
        
        DB::table('attestation_requests')
            ->whereIn('document_number', $hrDocumentNumbers)
            ->delete();
    }
};