# Logboek

This is a web-application for organizing (logging) information for (ICT-)forensic investigations. It lets different users maintain any number of logbooks and store text-entries within them.

## Requirements

* PHP > 5.4
* MySQL > 5.4

## Installation

* Clone the project into any place you like.
* Run `composer install`
* Edit the database configuration in `app/config/database.php`.
* `chmod -R 755 app/storage`
* Run `artisan migrate` and `artisan db:seed`.
* Point a virtualhost towards `<logboek_directory>/public`.
* Visit the site. The default login is `owner` with password `changeme`. (You can change this and add more users after logging in)
* Celebrate!
