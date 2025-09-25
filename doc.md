Pour voir les changements Tailwind, nous devons recompiler les assets CSS. Je vais exécuter les commandes nécessaires pour recompiler Tailwind.

To restart Windsurf, please reload the window (Ctrl+Shift+P, then select "Reload Window").


taskkill /f /im node.exe
npm run dev

// Pour creer un template
php artisan lions:create-template

// Pour importer les lions
php artisan db:seed

// Supprimer la base de données et la recreer et les remplir avec les seeds
php artisan migrate:fresh --seed
php artisan make:migration add_is_prestataire_to_users_table --table=users

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

// Pour tester la tâche planifiée manuellement :
php artisan contracts:update-expired
type storage\logs\laravel.log | Select-Object -Last 100


https://uxwing.com/finance-icon/


// Affiche les logs de la tâche planifiée
Get-Content storage\logs\laravel.log | Select-Object -Last 50 


php artisan migrate:fresh --seed 

"preDeployCommand": "php artisan migrate:fresh --force && php artisan db:seed --class=ProductionSeeder --force",