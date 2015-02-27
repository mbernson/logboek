# Logboek

This is a web-application for organizing and logging information for (ICT-)forensic investigations. It lets different users maintain any number of logbooks and store text-entries within them.

## Features

Logboek's primary features are:

* Maintaining forensic journals during your investigation.
* Assigning tasks to people in your team.
* Securely storing (and verifying) evidence files.
* Managing evidences and files;
	* Chain of Custody intergrated.

Also included are ways to:

* Export journals to CSV, Markdown, PDF and HTML (fast!).
* Keep a list of suspects.
* Solve mono-alphabatic ciphers.
* Dynamic settings, easy to change.
* Easy to change settings.

## Requirements

* PHP >= 5.4
* MySQL >= 5.5

## Installation

You can use Vagrant to set up a virtualized development environment. This is often the easiest way.
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
* Ensure your PHP process/server can write:
  * to `app/storage` (`chmod -R 777 app/storage`)
  * to `public/uploads` (`chmod -R 755 public/uploads`)
  * to `public/downloads` (`chmod -R 775 public/downloads`)
* Run `php artisan migrate` and `php artisan db:seed`
* Point a virtualhost to `<cloned_directory>/public`
* Visit the site. The default login is `owner` with password `changeme`
  * You can change this and add more users after logging in
* Celebrate!

## Update

* Git pull
* Run `composer migrate`
* Run `composer db:seed`

## License

This project is released under the [GPL v3 license](https://github.com/l0ngestever/logboek/blob/master/LICENSE.txt).


## TO DO (dutch)

1. entry uitbouwen
2. Python script executable
3. Projecten kunnen maken en daarin tussen wisselen
4. Voorbeeld knop
     1. http://www.codingdrama.com/bootstrap-markdown/
5. Kalender drop-down bij datums
6. Exporteren HTML verschillende items
7. Fix Attachments issue - gebruiker verwijderen + fout
8. Bewerken + verwijderen beveiligen andere gebruikers
