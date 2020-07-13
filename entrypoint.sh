#/bin/bash

if [ ! -e "vendor" ]; then
    composer install
    php artisan ide-helper:generate
    php artisan ide-helper:meta
fi

chmod 777 -R storage

if [ ! -e ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

php artisan migrate
