#!/bin/sh

set -e

export $(grep -v '^#' /var/www/html/.env | xargs)

echo "Instalando as bibliotecas"
composer install --optimize-autoloader --no-dev

echo "Generando a documentacao"
php artisan l5-swagger:generate --all

echo "Rodando as migrations..."
php artisan migrate

echo "Rodando as seeds..."
php artisan db:seed

echo "Rodando as seeds dos modulos..."
php artisan module:seed --class=DatabaseSeeder --all

# Configuracao das imagens
mkdir -p /var/www/html/storage/app/private && \
chown -R www-data:www-data /var/www/html/storage/app/private

mkdir -p /var/www/html/storage/app/backups && \
chown -R www-data:www-data /var/www/html/storage/app/backups

php-fpm &
nginx -g 'daemon off;'