#!/bin/sh

php artisan l5-swagger:generate --all

php artisan migrate --force

composer install --optimize-autoloader --no-dev

# Configuracao das imagens
mkdir -p /var/www/html/storage/app/private && \
chown -R www-data:www-data /var/www/html/storage/app/private

mkdir -p /var/www/html/storage/app/backups && \
chown -R www-data:www-data /var/www/html/storage/app/backups

exec php-fpm