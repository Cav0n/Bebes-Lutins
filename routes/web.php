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
/* ---------------- */

/**
* Products
*/
Route::get('/produits', 'ProductController@index');
Route::get('/produits/{product}', 'ProductController@show');
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
Route::get('/panier', 'ShoppingCartController@show');
Route::post('/panier/add_item', 'ShoppingCartItemController@store');
Route::post('/panier/change_quantity/{shoppingCartItem}', 'ShoppingCartItemController@update');
Route::delete('/panier/remove_item/{shoppingCartItem}', 'ShoppingCartItemController@destroy');
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
Route::get('/espace-client/commandes', 'CustomerAreaController@ordersPage'); //TODO
Route::get('/espace-client/commandes/{order}', 'OrderController@show'); //TODO
Route::get('/espace-client/adresses', 'CustomerAreaController@addressPage'); //TODO
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
//PRODUCTS
Route::get('/dashboard/produits', 'DashboardController@products'); //TODO
Route::get('/dashboard/produits/stocks', 'DashboardController@stocks'); //TODO
Route::get('/dashboard/produits/categories', 'DashboardController@categories'); //TODO
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
Route::get('/dashboard/newsletter', 'DashboardController@newsletters'); //TODO
/* ---------------- */