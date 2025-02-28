#!/bin/bash

# Copier le fichier d'environnement
cp .env.railway .env

# Générer la clé d'application
php artisan key:generate --force

# Migrations
php artisan migrate --force

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
