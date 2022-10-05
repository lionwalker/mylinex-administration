
# Mylinex Administration
## Getting started

## Installation

Require the mylinex/administration package in your composer.json and update your dependencies:

    composer require mylinex/administration:4.2.0

## Configuration

The defaults are set in config/app.php. Publish the config to copy the file to your own config:

    php artisan vendor:publish --provider="Administration\AdministrationServiceProvider"

Migrate database & seed

***Note*** : If you use existing database for php 8 project, please run db_cahanges.sql file.
    
    php artisan migrate

***Note*** : Before run db seeders,
Add this line to DatabaseSeeder.php in /database/seeds/

    $this->call([
        PermissionsTableSeeder::class,
        RolesTableSeeder::class,
        UsersTableSeeder::class
    ]);


    php artisan db:seed

Run development server

    php artisan serve


