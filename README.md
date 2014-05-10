# Logboek

This is a web-application for organizing (logging) information for (ICT-)forensic investigations. It lets different users maintain any number of logbooks and store text-entries within them.

## Requirements

* PHP > 5.4
* MySQL > 5.4

## Installation

1. Clone the project into any place you like.
2. Edit the database configuration in `app/config/database.php`.
3. Run `artisan migrate` and `artisan db:seed`.
4. Point a virtualhost towards `<logboek directory/public`.
5. Visit the site. The default login is `owner` with password `changeme`. (You'll have to drop into the Laravel console to create more users, this functionality be added later on.)
5. Celebrate!