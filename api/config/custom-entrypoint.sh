#!/bin/sh

php artisan l5-swagger:generate

php artisan migrate --force

composer install --optimize-autoloader --no-dev

exec php-fpm