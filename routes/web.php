<?php

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

Route::get('/', 'PageController@index');

/**
 * Categories
 */
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{category}', 'CategoryController@show');
Route::post('/categories/{category}', 'CategoryController@getJSON');
/* ---------------- */

/**
* Products
*/
Route::get('/produits', 'ProductController@index');
Route::get('/produits/{product}', 'ProductController@show');
Route::post('/produits/{product}', 'ProductController@getJSON');
Route::get('/produits/{category}/{product}', 'ProductController@show');
Route::post('/produits/selectionner_categorie/{category}', 'ProductController@add_selected_category');
Route::post('/produits/deselectionner_categorie/{category}', 'ProductController@unselected_category');
/* ---------------- */

/**
 * Reviews
 */
Route::post('/nouveau_commentaire/{product}', 'ReviewController@store');
Route::delete('/commentaires/supprimer/{review}', 'ReviewController@destroy');
/* ---------------- */

/**
 * Shopping cart
 */
Route::get('/panier/partage/{shopping_cart}', 'ShoppingCartController@show');
Route::get('/panier/partage/{shopping_cart}/commander', 'ShoppingCartController@replace');

Route::get('/panier', 'ShoppingCartController@show');
Route::post('/panier/add_item', 'ShoppingCartItemController@store');
Route::post('/panier/change_quantity/{shoppingCartItem}', 'ShoppingCartItemController@update');
Route::delete('/panier/remove_item/{shoppingCartItem}', 'ShoppingCartItemController@destroy');
Route::post('/panier/code-coupon/ajouter', 'ShoppingCartController@addVoucher');
Route::post('/panier/code-coupon/supprimer', 'ShoppingCartController@removeVoucher');

Route::get('/panier/livraison', 'ShoppingCartController@showDelivery');
Route::post('/panier/livraison/validation', 'ShoppingCartController@validateDelivery');

Route::get('/panier/paiement', 'ShoppingCartController@showPayment');
Route::get('/panier/paiement/carte-bancaire', 'ShoppingCartController@showCreditCardPayment');

Route::get('/panier/paiement/validation/cheque', 'ShoppingCartController@validateChequePayment');
Route::get('/panier/paiement/validation/carte-bancaire', 'ShoppingCartController@validateCreditCartPayment');
Route::get('/merci', 'OrderController@showThanks');
 /* ---------------- */

/**
 * Customer area
 */
Auth::routes();

Route::get('/espace-client', 'CustomerAreaController@index'); //TODO
Route::get('/espace-client/connexion', 'CustomerAreaController@loginPage')->name('connexion'); //TODO
Route::post('/espace-client/connexion', 'CustomerAreaController@login')->name('connexion'); //TODO

Route::get('/espace-client/enregistrement', 'CustomerAreaController@registerPage'); //TODO
Route::post('/espace-client/enregistrement', 'CustomerAreaController@register'); //TODO

Route::get('/espace-client/profil', 'CustomerAreaController@profilPage'); //TODO
Route::post('/espace-client/newsletter-invert', 'CustomerAreaController@invertNewsletter');
Route::get('/espace-client/commandes', 'CustomerAreaController@ordersPage'); //TODO
Route::get('/espace-client/commandes/{order}', 'OrderController@show'); //TODO
Route::post('/commandes/{order}', 'OrderController@getJSON');

Route::get('/espace-client/adresses', 'CustomerAreaController@addressPage'); //TODO
Route::get('/espace-client/adresses/creation', 'AddressController@create');
Route::post('/espace-client/adresses/creation','AddressController@store');
Route::get('/espace-client/adresses/edition/{address}', 'AddressController@edit');
Route::post('/espace-client/adresses/mise-a-jour/{address}', 'AddressController@update');
Route::delete('/espace-client/adresses/{address}', 'AddressController@destroy');
/* ---------------- */

/**
* Dashboard
*/
Route::get('/dashboard', 'DashboardController@index'); //TODO
//ORDERS
Route::get('/dashboard/commandes', 'DashboardController@orders'); //TODO
Route::get('/dashboard/commandes/{status}', 'DashboardController@orders'); //TODO
Route::post('/dashboard/commandes/changer_status/{order}', 'OrderController@update');
Route::post('/dashboard/commandes/select_order_status', 'DashboardController@select_order_status');
Route::post('/dashboard/commandes/unselect_order_status', 'DashboardController@unselect_order_status');
Route::post('/dashboard/commandes/rechercher', 'OrderController@search');
//PRODUCTS
Route::get('/dashboard/produits', 'DashboardController@products'); //TODO
Route::get('/dashboard/produits/nouveau', 'ProductController@create');
Route::post('/dashboard/produits/nouveau', 'ProductController@store');
Route::get('/dashboard/produits/edition/{product}', 'ProductController@edit');
Route::post('/dashboard/produits/edition/{product}', 'ProductController@update');
Route::get('/dashboard/produits/stocks', 'DashboardController@stocks'); //TODO
//CATEGORIES
Route::get('/dashboard/produits/categories', 'DashboardController@categories'); //TODO
Route::get('/dashboard/produits/categories/nouvelle', 'CategoryController@create');
Route::post('/dashboard/produits/categories/nouvelle', 'CategoryController@store');
Route::get('/dashboard/produits/categories/edition/{category}', 'CategoryController@edit');
Route::post('/dashboard/produits/categories/edition/{category}', 'CategoryController@update');
Route::get('/dashboard/produits/categories/rang/{category}/{rank}', 'CategoryController@updateRank');
Route::get('/dashboard/switch_is_hidden_product/{product}', 'ProductController@switchIsHidden');
Route::get('/dashboard/switch_is_hidden_category/{category}', 'CategoryController@switchIsHidden');
//CUSTOMERS
Route::get('/dashboard/clients', 'DashboardController@customers'); //TODO
Route::get('/dashboard/clients/avis', 'DashboardController@reviews');
Route::get('/dashboard/clients/avis/{review}', 'ReviewController@show');
Route::post('/dashboard/clients/avis/repondre/{review}', 'ReviewController@update');
Route::post('/dashboard/clients/avis/supprimer-reponse/{review}','ReviewController@update');
//OTHERS
Route::get('/dashboard/reductions', 'DashboardController@vouchers'); //TODO
Route::get('/dashboard/reductions/nouveau', 'VoucherController@create'); //TODO
Route::post('/dashboard/reductions/nouveau', 'VoucherController@store');
Route::get('/dashboard/reductions/edition/{voucher}', 'VoucherController@edit');
Route::post('/dashboard/reductions/edition/{voucher}', 'VoucherController@update');
Route::get('/dashboard/newsletter', 'DashboardController@newsletters'); //TODO
Route::post('/upload_image', 'ImageController@store');
Route::delete('/delete_image', 'ImageController@destroy');
/* ---------------- */

/**
 * UTILS
 */
Route::post('/addresses/{address}', 'AddressController@get');
 /* ---------------- */