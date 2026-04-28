#!/bin/sh
set -e

PORT="${PORT:-10000}"

sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is not set. Generate one with 'php artisan key:generate --show' and add it in Render."
    exit 1
fi

php artisan package:discover --ansi
php artisan config:clear --ansi
php artisan route:clear --ansi
php artisan view:clear --ansi
php artisan migrate:fresh --seed --force --ansi

exec "$@"