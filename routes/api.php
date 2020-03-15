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
