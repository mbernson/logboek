#!/usr/bin/env bash

# Initialize the application.
# This assumes the database has been set up.

cd logboek

php artisan env
php artisan migrate
php artisan db:seed
