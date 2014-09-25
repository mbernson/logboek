# Logboek

This is a web-application for organizing (logging) information for (ICT-)forensic investigations. It lets different users maintain any number of logbooks and store text-entries within them.

## Features

Logboek's primary features are:

* Maintaining forensic journals (logbooks) during your investigation.
* Assigning tasks to people in your team.
* Securely storing evidence files.

## Requirements

* PHP > 5.4
* MySQL > 5.4

## Installation

* Clone the project
* Run `composer install`
* Copy the configuration folder `app/config/production.example` to `app/config/production`
  * Use `app/config/local.example` and `app/config/local` for development
* Edit your configuration
* Generate a secret key with `php artisan key:generate`
* Ensure your PHP process/server can write to `app/storage` (`chmod -R 755 app/storage`)
* Run `php artisan migrate` and `php artisan db:seed`
* Point a virtualhost to `<cloned_directory>/public`
* Visit the site. The default login is `owner` with password `changeme`
  * You can change this and add more users after logging in
* Celebrate!

## License

This project is released under the [GPL v3 license](https://github.com/mbernson/logboek/blob/master/LICENSE.txt).
