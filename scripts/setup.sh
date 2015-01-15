#!/usr/bin/env bash

# Initialize the Laravel application.
# This assumes the database has been set up.

cd logboek

composer install

php artisan env
php artisan migrate
php artisan db:seed
