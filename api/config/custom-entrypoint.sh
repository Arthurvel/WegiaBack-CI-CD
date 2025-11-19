#!/bin/sh

set -e

export $(grep -v '^#' /var/www/html/.env | xargs)

composer install --optimize-autoloader --no-dev

php artisan l5-swagger:generate --all

php artisan migrate

# Configuracao das imagens
mkdir -p /var/www/html/storage/app/private && \
chown -R www-data:www-data /var/www/html/storage/app/private

mkdir -p /var/www/html/storage/app/backups && \
chown -R www-data:www-data /var/www/html/storage/app/backups

php-fpm &
nginx -g 'daemon off;'