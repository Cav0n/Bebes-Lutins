![Laravel](https://github.com/Cav0n/Bebes-Lutins/workflows/Laravel/badge.svg?branch=develop)
![Node.js CI](https://github.com/Cav0n/Bebes-Lutins/workflows/Node.js%20CI/badge.svg?branch=master)
[![Build Status](https://travis-ci.com/Cav0n/Bebes-Lutins.svg?branch=develop)](https://travis-ci.com/Cav0n/Bebes-Lutins)

# Bebes Lutins
This is a Laravel based website for the company Actypoles/Bébés Lutins

## Requirements
### Apache
mod_rewrite has to be enabled :
- sudo a2enmod rewrite
- sudo service apache2 restart

## Installation
- composer install
- npm install
- npm run dev

## Telescope (debugger)
- composer require laravel/telescope
- php artisan telescope:install
- php artisan migrate
- uncomment this in app/Providers/AppServiceProvider.php - register(): 
```
if ($this->app->isLocal()) {
	$this->app->register(TelescopeServiceProvider::class);
}
```
- uncomment this in config/app.php : 
```
App\Providers\TelescopeServiceProvider::class,
```
