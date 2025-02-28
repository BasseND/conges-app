#!/bin/bash

# Attendre que MySQL soit prêt
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$MYSQLHOST" -P"$MYSQLPORT" -u"$MYSQLUSER" -p"$MYSQLPASSWORD" --silent; do
    echo "MySQL is unavailable - sleeping"
    sleep 1
done
echo "MySQL is ready!"

# Copier le fichier d'environnement
cp .env.railway .env

# Vérifier les permissions
chown -R www-data:www-data storage bootstrap/cache

# Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
php artisan migrate --force

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
