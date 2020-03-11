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

Route::get('/', 'MainController@index')->name('homepage');


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
Route::get('/espace-client/mes-commandes', 'CustomerArea\MainController@orders')->name('customer.area.orders');
Route::get('/espace-client/mes-adresses', 'CustomerArea\MainController@addresses')->name('customer.area.addresses');

Route::get('/espace-client/newsletters/toggle/{user}', 'UserController@toggleNewsletters')->name('user.newsletters.toggle');

Route::post('/espace-client/adresses/ajouter', 'AddressController@store')->name('user.addresses.create');
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
Route::get('/panier/paiement', 'CartController@showPayment')->name('cart.payment');
Route::post('/panier/ajout/{product}/{cart}', 'CartItemController@create')->name('cart.item.add');
Route::post('/panier/modifier-quantite/{cartItem}', 'CartItemController@update')->name('cart.item.updateQuantity');
Route::get('/panier/{cartItem}/supprimer', 'CartItemController@destroy')->name('cart.item.delete');
/** ============ */

/**
 * ============
 * ORDERS
 * ============
 */
Route::get('/commande/validation/{cart}', 'OrderController@createFromCart')->name('order.createFromCart');
Route::get('/merci/{order}', 'MainController@thanks')->name('thanks');
Route::get('/commande/suivi', 'OrderController@showTrackingPage')->name('order.tracking.show');
/** ============ */

/**
 * ============
 * ORDERS
 * ============
 */
Route::get('/admin', 'Admin\AdminController@index')->name('admin.homepage');
 /** ============ */

/**
 * ============
 * STATIC
 * ============
 */
Route::get('/contact', function(){
    return view('pages.static.contact');
})->name('contact');
Route::post('/contact', 'MainController@contact');
  /** ============ */
