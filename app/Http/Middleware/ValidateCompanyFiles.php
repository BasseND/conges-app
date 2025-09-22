<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class ValidateCompanyFiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nettoyer les références de fichiers inexistants avant de traiter la requête
        $this->cleanMissingFiles();
        
        return $next($request);
    }
    
    /**
     * Nettoie les références de fichiers inexistants
     */
    private function cleanMissingFiles(): void
    {
        try {
            $companies = Company::whereNotNull('logo')
                ->orWhereNotNull('hr_signature')
                ->get();
                
            foreach ($companies as $company) {
                $updated = false;
                
                // Vérifier le logo
                if ($company->logo && !Storage::disk('public')->exists($company->logo)) {
                    Log::warning("Logo manquant supprimé pour {$company->name}: {$company->logo}");
                    $company->logo = null;
                    $updated = true;
                }
                
                // Vérifier la signature
                if ($company->hr_signature && !Storage::disk('public')->exists($company->hr_signature)) {
                    Log::warning("Signature manquante supprimée pour {$company->name}: {$company->hr_signature}");
                    $company->hr_signature = null;
                    $updated = true;
                }
                
                if ($updated) {
                    $company->save();
                }
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors du nettoyage des fichiers manquants: ' . $e->getMessage());
        }
    }
}
