#!/bin/sh
set -e

# APP_KEY sudah di-set permanen lewat Environment Variable di Coolify,
# jadi TIDAK perlu key:generate di sini.

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

php-fpm -D
nginx -g "daemon off;"
