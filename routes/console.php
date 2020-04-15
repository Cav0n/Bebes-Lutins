<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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
