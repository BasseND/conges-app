J'arrive pas à me connecter. Quand je soumets mon formulaire je reste sur la page de connexion. Je ne vois pas pourquoi. J'ai l'impression que le front ne communique pas avec le back. 
Voici mes variables Railway :

APP_DEBUG="true"
APP_ENV="production"
APP_KEY="base64:PQQKHZ/jgKWxqNnQMqWElMkdmncoBunW7dftMS7dX+o="
APP_NAME="Laravel"
APP_URL="https://conges-app-production.up.railway.app"
ASSET_URL="https://conges-app-production.up.railway.app"
AWS_ACCESS_KEY_ID=""
AWS_BUCKET=""
AWS_DEFAULT_REGION="us-east-1"
AWS_SECRET_ACCESS_KEY=""
AWS_USE_PATH_STYLE_ENDPOINT="false"
BROADCAST_DRIVER="log"
CACHE_DRIVER="file"
DB_CONNECTION="mysql"
DB_DATABASE="railway"
DB_HOST="mysql.railway.internal"
DB_PASSWORD="my_password"
DB_PORT="3306"
DB_USERNAME="root"
FILESYSTEM_DISK="public"
FORCE_HTTPS="true"
LOG_CHANNEL="stack"
LOG_DEPRECATIONS_CHANNEL="null"
LOG_LEVEL="debug"
MAIL_ENCRYPTION="tls"
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
MAIL_HOST="sandbox.smtp.mailtrap.io"
MAIL_MAILER="smtp"
MAIL_PASSWORD="2b2578eed0e7f0"
MAIL_PORT="2525"
MAIL_USERNAME="608e620e27ed19"
MEMCACHED_HOST="127.0.0.1"
PUSHER_APP_CLUSTER="mt1"
PUSHER_APP_ID=""
PUSHER_APP_KEY=""
PUSHER_APP_SECRET=""
PUSHER_HOST=""
PUSHER_PORT="443"
PUSHER_SCHEME="https"
QUEUE_CONNECTION="sync"
REDIS_HOST="127.0.0.1"
REDIS_PASSWORD="null"
REDIS_PORT="6379"
SANCTUM_STATEFUL_DOMAINS="conges-app-production.up.railway.app"
SESSION_DOMAIN="conges-app-production.up.railway.app"
SESSION_DRIVER="file"
SESSION_LIFETIME="10080"
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"

Alors je suis un perdu avec les variables de l'environnement et les variables qu'on a mis dans le .env.railway. Je pense qu'il a du travail à faire pour mettre tous ça clair.