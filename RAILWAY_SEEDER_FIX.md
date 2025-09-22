# Configuration Automatique du Déploiement Railway

## Problème Résolu
Les types de congés spéciaux et autres données de base ne sont pas présents sur Railway après le déploiement.

## Solution Automatique avec railway.json

### ✅ Configuration Automatique (Recommandée)
Le fichier `railway.json` a été créé pour automatiser complètement le déploiement :

```json
{
  "$schema": "https://railway.com/railway.schema.json",
  "build": {
    "builder": "NIXPACKS",
    "buildCommand": "npm run build && php artisan optimize:clear && php artisan config:cache && php artisan event:cache && php artisan route:cache && php artisan view:cache"
  },
  "deploy": {
    "preDeployCommand": [
      "php artisan migrate --force",
      "php artisan db:seed --class=Database\\Seeders\\ProductionSeeder --force"
    ],
    "startCommand": null,
    "healthcheckPath": "/",
    "healthcheckTimeout": 300,
    "restartPolicyType": "on-failure"
  }
}
```

### Avantages de cette approche
- ✅ **Automatique** : Migrations et seeders s'exécutent à chaque déploiement
- ✅ **Optimisé** : Cache Laravel optimisé pour la production
- ✅ **Sécurisé** : Utilise `--force` pour éviter les prompts interactifs
- ✅ **Robuste** : Healthcheck et politique de redémarrage configurés
- ✅ **Versionné** : Configuration dans le code source

### Solutions Manuelles (Si nécessaire)

#### Option 1: Railway CLI
```bash
railway login
railway link
railway run php artisan db:seed --class=Database\\Seeders\\ProductionSeeder
```

#### Option 2: Interface Railway
1. Aller sur railway.app → Votre projet → Deployments
2. Cliquer sur "Connect" pour ouvrir un terminal
3. Exécuter: `php artisan db:seed --class=Database\\Seeders\\ProductionSeeder`

## Vérification
Après exécution, vous devriez avoir:
- ✅ 4+ types de congés spéciaux (congé annuel, maternité, paternité, maladie)
- ✅ 8 types d'attestation
- ✅ 5 départements (IT, HR, FIN, MKT, OPS)
- ✅ Utilisateurs de base (admin, hr, managers)

## Types de Congés Créés
Le seeder crée automatiquement:
1. **Congé annuel** - 25 jours
2. **Congé maternité** - 112 jours (16 semaines)
3. **Congé paternité** - 28 jours (4 semaines)
4. **Congé maladie** - 30 jours

## Script de Vérification
Utilisez le script `check_production_seeders.php` pour vérifier l'état des données:
```bash
php check_production_seeders.php
```

## Note Importante
Le `ProductionSeeder` utilise `firstOrCreate()` et `updateOrCreate()`, donc il peut être exécuté plusieurs fois sans créer de doublons.