#!/bin/bash

cd /var/www/html;
php -r "file_exists('.env') || copy('.env.example', '.env');"
composer install
chmod 777 -R storage bootstrap
php artisan config:cache
php artisan migrate
php artisan module:migrate

if [[ -z "${APP_KEY}" ]]; then
    php artisan key:generate
fi

/srv/commands.sh