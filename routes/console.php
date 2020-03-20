<?php

use Illuminate\Foundation\Inspiring;

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

Artisan::command('import:all', function() {
    $productController = new \App\Http\Controllers\ProductController();
    $productController->importFromJSON();
    $productController->importImagesFromJSON();

    $categoryController = new \App\Http\Controllers\CategoryController();
    $categoryController->importFromJSON();
    $categoryController->importImagesFromJSON();
    $categoryController->importRelationsFromJSON();

    $userController = new \App\Http\Controllers\UserController();
    $userController->importFromJSON();
})->describe('Import all data from previous version');
