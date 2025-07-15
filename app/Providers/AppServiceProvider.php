<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\View\Composers\CompanyComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('fr');
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
        
        // Forcer HTTPS en production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Créer le lien symbolique storage si il n'existe pas (nécessaire sur Railway)
        $this->createStorageLink();
        
        // Enregistrer le View Composer pour les données de la société
        View::composer('*', CompanyComposer::class);
    }
    
    /**
     * Créer le lien symbolique storage si il n'existe pas
     */
    private function createStorageLink(): void
     {
         $target = storage_path('app/public');
         $link = public_path('storage');
         
         \Log::info('Tentative de création du lien symbolique storage', [
             'target' => $target,
             'link' => $link,
             'link_exists' => file_exists($link),
             'target_exists' => file_exists($target)
         ]);
         
         // Vérifier si le lien n'existe pas déjà
         if (!file_exists($link)) {
             try {
                 // Créer le répertoire storage/app/public s'il n'existe pas
                 if (!file_exists($target)) {
                     mkdir($target, 0755, true);
                     \Log::info('Répertoire target créé: ' . $target);
                 }
                 
                 // Créer le lien symbolique
                 if (function_exists('symlink')) {
                     $result = symlink($target, $link);
                     \Log::info('Résultat symlink: ' . ($result ? 'succès' : 'échec'));
                 } else {
                     // Fallback pour les systèmes qui ne supportent pas symlink
                     \Log::info('symlink non disponible, utilisation du fallback');
                     $this->copyDirectory($target, $link);
                 }
             } catch (\Exception $e) {
                 // Log l'erreur mais ne pas faire planter l'application
                 \Log::warning('Impossible de créer le lien symbolique storage: ' . $e->getMessage());
             }
         } else {
             \Log::info('Le lien symbolique storage existe déjà');
         }
     }
    
    /**
     * Copier un répertoire (fallback si symlink ne fonctionne pas)
     */
    private function copyDirectory(string $source, string $destination): void
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0755, true);
                }
            } else {
                copy($item, $target);
            }
        }
    }
}
