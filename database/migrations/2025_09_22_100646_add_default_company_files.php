<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nettoyer les références de fichiers inexistants
        $companies = Company::whereNotNull('logo')
            ->orWhereNotNull('hr_signature')
            ->get();
            
        foreach ($companies as $company) {
            $updated = false;
            
            // Vérifier le logo
            if ($company->logo && !Storage::disk('public')->exists($company->logo)) {
                $company->logo = null;
                $updated = true;
            }
            
            // Vérifier la signature
            if ($company->hr_signature && !Storage::disk('public')->exists($company->hr_signature)) {
                $company->hr_signature = null;
                $updated = true;
            }
            
            if ($updated) {
                $company->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rien à faire pour le rollback
    }
};
