# Logboek

This is a web-application for organizing and logging information for (ICT-)forensic investigations. It lets different users maintain any number of logbooks and store text-entries within them.

## Features

Logboek's primary features are:

* Maintaining forensic journals during your investigation.
* Assigning tasks to people in your team.
* Managing evidences and files;
	* Chain of Custody management.

Also included are ways to:

* Quickly export your journals to CSV, Markdown, PDF and HTML.
* Keep a list of suspects.
* Manage references to the laws used in your case.
* Solve mono-alphabatic ciphers.
* Change the menus and preferences.

## Requirements

* PHP >= 5.4
* MySQL >= 5.5

## Installation

If you'd like to run logboek locally, Vagrant is the recommended way to do so.
Manual installation instructions are also available.

### Vagrant

Ensure you have [Vagrant](http://vagrantup.com) and [Virtualbox](https://www.virtualbox.org) installed first.

* Clone the project
* Run `vagrant up`
* Add `192.168.10.10  logboek.app` to your hosts file
* The application should now be accessible at `http://logboek.app`
	* The default login is `owner` with password `changeme`
	* You can also use the VM's IP address instead
* Celebrate!

Consult the [documentation on Laravel Homestead](http://laravel.com/docs/4.2/homestead) for further usage of the VM.

### Manual installation

* Clone the project
* Run `composer install`
* Copy the configuration folder `app/config/production.example` to `app/config/production`
  * Use `app/config/local.example` and `app/config/local` for development
* Edit your configuration
* Generate a secret key with `php artisan key:generate`
* Ensure your PHP process/server can write to the following directories:
  * to `app/storage` (`chmod -R 755 app/storage`)
  * to `public/uploads` (`chmod -R 755 public/uploads`)
  * to `public/downloads` (`chmod -R 775 public/downloads`)
* Run `php artisan migrate` and `php artisan db:seed`
* Point a virtualhost to `<cloned_directory>/public`
* Visit the site. The default login is `owner` with password `changeme`
  * You can change this and add more users after logging in
* Celebrate!

## Update

* Pull the latest source code via Git.
* Run `composer install`
* Run `php artisan migrate`
* Run `php artisan db:seed` if you haven't done so already.

## License

This project is released under the [GPL v3 license](https://github.com/l0ngestever/logboek/blob/master/LICENSE.txt).

## TO DO (dutch)

1. entry uitbouwen
2. Python script executable
3. Kalender drop-down bij datums
4. Exporteren HTML verschillende items
5. Bewerken + verwijderen beveiligen andere gebruikers
6. Chain of custody markdown wysiwyg editor toevoegen
