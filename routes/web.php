<?php

use Illuminate\Support\Facades\Route; // Fix for VS Code

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index');


/**
 * ============
 * AUTH
 * ============
 */

// Connexion
Route::get('/connexion', 'Auth\LoginController@showLoginPage')->name('login');
Route::post('/connexion', 'Auth\LoginController@login');

// Registration
Route::get('/enregistrement', 'Auth\RegisterController@showRegistrationPage')->name('registration');
Route::post('/enregistrement', 'Auth\RegisterController@register');

// Logout
Route::any('/logout', 'Auth\LoginController@logout')->name('logout');
/** =========== */

/**
 * ============
 * CUSTOMER AREA
 * ============
 */
Route::get('/espace-client', 'CustomerArea\MainController@index')->name('customer.area');
/** ============ */

/**
 * ============
 * CATEGORY
 * ============
 */
Route::get('/categories/{category}', 'CategoryController@show')->name('category');
/** ============ */

/**
 * ============
 * PRODUCT
 * ============
 */
Route::get('/produits/{product}', 'ProductController@show')->name('product');
/** ============ */

/**
 * ============
 * SHOPPING CART
 * ============
 */
Route::get('/panier', 'CartController@show')->name('cart');
Route::get('/panier/livraison', 'CartController@showDelivery')->name('cart.delivery');
Route::post('/panier/livraison/valider', 'CartController@addAddresses')->name('cart.delivery.validation');
Route::get('/panier/ajout/{product}/{cart}', 'CartItemController@create')->name('cart.item.add');
Route::get('/panier/{cartItem}/supprimer', 'CartItemController@destroy')->name('cart.item.delete');
/** ============ */
