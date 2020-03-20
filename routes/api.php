<?php

use Illuminate\Support\Facades\Route; // Fix for VS Code

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/product/{product}', 'ProductController@apiGet')->name('api.product');
Route::get('/order/tracking/{trackingNumber}', 'OrderController@tracking')->name('api.order.tracking');
Route::post('/cart_item/{cartItem}/quantity/update', 'CartItemController@update')->name('api.cart_item.quantity.update');
Route::post('/order/{order}/status/update', 'OrderController@update')->name('api.order.status.update');

// IMPORTS
Route::get('/images/import', 'ImageController@importFromJSON')->name('api.images.import');
Route::get('/products/import', 'ProductController@importFromJSON')->name('api.products.import');
Route::get('/products/import/images', 'ProductController@importImagesFromJSON')->name('api.products.import.images');
Route::get('/categories/import', 'CategoryController@importFromJSON')->name('api.categories.import');
Route::get('/categories/import/images', 'CategoryController@importImagesFromJSON')->name('api.categories.import.images');
Route::get('/categories/import/relations', 'CategoryController@importRelationsFromJSON')->name('api.categories.import.relations');
Route::get('/users/import', 'UserController@importFromJSON')->name('api.users.import');
Route::get('/addresses/import', 'AddressController@importFromJSON')->name('api.addresses.import');
Route::get('/orders/import', 'OrderController@importFromJSON')->name('api.orders.import');
Route::get('/orders/import/items', 'OrderItemController@importFromJSON')->name('api.orders.import.items');
