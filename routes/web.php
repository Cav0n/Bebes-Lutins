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

// Password lost
Route::get('/mot-de-passe-perdu', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.lost.form');
Route::post('/mot-de-passe-perdu', 'Auth\ForgotPasswordController@passwordReset')->name('password.lost.reset');
Route::post('/mot-de-passe-perdu/verification-code', 'Auth\ResetPasswordController@verifyResetCode')->name('password.reset.verify_code');
Route::post('/mot-de-passe/reinitialisation', 'Auth\ResetPasswordController@resetPassword')->name('password.reset');
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
Route::post('/produits/{product}/ajout-commentaire', 'ReviewController@store')->name('product.reviews.add');
/** ============ */

/**
 * ============
 * SHOPPING CART
 * ============
 */
Route::get('/panier', 'CartController@show')->name('cart')->middleware('\App\Http\Middleware\SessionCartUpdate');
Route::get('/panier/livraison', 'CartController@showDelivery')->name('cart.delivery');
Route::post('/panier/livraison/valider', 'CartController@addAddresses')->name('cart.delivery.validation');
Route::get('/panier/paiement', 'CartController@showPayment')->name('cart.payment');
Route::post('/panier/ajout/{product}/{cart}', 'CartItemController@create')->name('cart.item.add');
Route::post('/panier/modifier-quantite/{cartItem}', 'CartItemController@update');
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
 * STATIC
 * ============
 */
Route::get('/contact', 'MainController@showContact')->name('contact');
Route::post('/contact', 'MainController@contact');

Route::get('/contenu/{content}', 'ContentController@show')->name('content.show');
 /** ============ */

/**
 * ============
 * ADMIN
 * ============
 */
Route::get('/admin', 'Admin\AdminController@index')->name('admin');
Route::get('/admin/connexion', 'Admin\LoginController@showLoginPage')->name('admin.login');
Route::post('/admin/connexion', 'Admin\LoginController@login')->name('admin.login');
Route::any('/admin/logout', 'Admin\LoginController@logout')->name('admin.logout');

// Models indexes
Route::get('/admin/orders', 'OrderController@index')->name('admin.orders');
Route::get('/admin/products', 'ProductController@index')->name('admin.products');
Route::get('/admin/categories', 'CategoryController@index')->name('admin.categories');
Route::get('/admin/customers', 'UserController@index')->name('admin.customers');
Route::get('/admin/contents', 'ContentController@index')->name('admin.contents');
Route::get('/admin/reviews', 'MainController@page404')->name('admin.reviews');
// Models creation
Route::get('/admin/product/create', 'ProductController@create')->name('admin.product.create');
Route::post('/admin/product/create', 'ProductController@store')->name('admin.product.store');
Route::get('/admin/content/create', 'ContentController@create')->name('admin.content.create');
Route::post('/admin/content/create', 'ContentController@store')->name('admin.content.store');
// Models edition
Route::get('/admin/order/{order}', 'OrderController@show')->name('admin.order.show');
Route::get('/admin/product/{product}', 'ProductController@edit')->name('admin.product.edit');
Route::post('/admin/product/{product}', 'ProductController@update')->name('admin.product.edit');
Route::get('/admin/category/{category}', 'CategoryController@edit')->name('admin.category.edit');
Route::post('/admin/category/{category}', 'CategoryController@update')->name('admin.category.edit');
Route::get('/admin/customer/{user}', 'UserController@edit')->name('admin.customer.edit');
Route::get('/admin/content/{content}/edit', 'ContentController@edit')->name('admin.content.edit');
Route::post('/admin/content/{content}/edit', 'ContentController@update')->name('admin.content.edit');
// Search
Route::get('/admin/search/orders', 'Admin\SearchController@orders')->name('admin.search.orders');
Route::get('/admin/search/products', 'Admin\SearchController@products')->name('admin.search.products');
Route::get('/admin/search/categories', 'Admin\SearchController@categories')->name('admin.search.categories');
Route::get('/admin/search/customers', 'Admin\SearchController@customers')->name('admin.search.customers');
Route::get('/admin/search/contents', 'Admin\SearchController@contents')->name('admin.search.contents');
 /** ============ */
