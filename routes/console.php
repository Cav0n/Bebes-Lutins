<?php

use App\FooterElement;
use App\Http\Controllers\FooterElementController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('import:all', function () {
    $importController = new \App\Http\Controllers\ImportController();
    if (! $importController->testApi()) {
        echo 'Importation API is not accessible (maybe desactivated) !';
        return;
    }

    $productController = new \App\Http\Controllers\ProductController();
    $productController->importFromJSON();
    $productController->importImagesFromJSON();

    $categoryController = new \App\Http\Controllers\CategoryController();
    $categoryController->importFromJSON();
    $categoryController->importImagesFromJSON();
    $categoryController->importRelationsFromJSON();

    $adminController = new \App\Http\Controllers\AdminController();
    $adminController->importFromJSON();

    $userController = new \App\Http\Controllers\UserController();
    $userController->importFromJSON();

    $addressController = new \App\Http\Controllers\AddressController();
    $addressController->importFromJSON();

    $orderController = new \App\Http\Controllers\OrderController();
    $orderController->importFromJSON();

    $orderItemController = new \App\Http\Controllers\OrderItemController();
    $orderItemController->importFromJSON();

    echo 'Everything imported, enjoy 👨‍💻 \n';
})->describe('Import all data from previous version');

Artisan::command('import:settings', function () {
    $settingController = new \App\Http\Controllers\SettingController;
    $settingController->generateAll();
})->describe('Import all settings from /config/settings.json');

Artisan::command('carts:reset', function() {
    exec('rm -rf ' . storage_path('framework/sessions/*'));
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('cart_items')->truncate();
    DB::table('carts')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo 'Carts reseted!';
})->describe('Reset all shopping carts');

Artisan::command('bebes-lutins:install', function() {
    shell_exec('composer install');
    shell_exec('php artisan migrate:fresh');
    shell_exec('php artisan import:all');
    shell_exec('php artisan import:settings');
    shell_exec('php artisan db:seed --class=CarouselItemSeeder');
    shell_exec('php artisan carts:reset');
    shell_exec('php artisan config:cache');
    shell_exec('php artisan route:cache');
    shell_exec('php artisan view:cache');
    shell_exec('composer install --optimize-autoloader --no-dev');

})->describe('Install the website');

Artisan::command('content:generate', function() {
    FooterElementController::createFromLocalJSON();
})->describe('Generate all contents');
