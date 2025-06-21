#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ]; then
  cp .env.example .env
fi

mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache

echo "*\n!.gitignore" | tee storage/framework/cache/.gitignore \
                       storage/framework/sessions/.gitignore \
                       storage/framework/views/.gitignore > /dev/null

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage
chmod -R 775 storage

rm -f bootstrap/cache/config.php /var/run/crond.pid

composer install --no-interaction --prefer-dist --optimize-autoloader

if [ -n "$DB_HOST" ] && [ -n "$DB_PORT" ]; then
  echo "Waiting for database to be ready..."
  until mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1;" "$DB_DATABASE"; do
    >&2 echo "MySQL is unavailable - sleeping"
    sleep 2
  done
  echo "MySQL is up - continuing"
fi

if ! grep -q "APP_KEY=" .env || [ -z "$(grep APP_KEY= .env | cut -d '=' -f2)" ]; then
  php artisan key:generate
fi

php artisan migrate --force

exec "$@"
