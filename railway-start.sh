#!/bin/bash

# Copier le fichier d'environnement
cp .env.railway .env

# Générer la clé d'application si nécessaire
php artisan key:generate --force

# Créer les tables de cache et sessions
php artisan cache:table
php artisan session:table
php artisan migrate --force

# Optimisations de production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
