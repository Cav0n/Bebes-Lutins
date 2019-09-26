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

Route::get('/', function () {
    return view('homepage');
});

/**
 * Categories
 */
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{category}', 'CategoryController@show');
/* ----------------*/

/**
* Products
*/
Route::get('/produits', 'ProductController@index');
Route::get('/produits/{product}', 'ProductController@show');
Route::get('/produits/{category}/{product}', 'ProductController@show');
/* ----------------*/

/**
 * Customer Area
 */
Route::get('/espace-client', 'CustomerAreaController@index'); //TODO
Route::get('/espace-client/connexion', 'CustomerAreaController@loginPage')->name('connexion'); //TODO
Route::post('/espace-client/connexion', 'CustomerAreaController@login')->name('connexion'); //TODO
Route::get('/espace-client/enregistrement', 'CustomerAreaController@registerPage'); //TODO
Route::post('/espace-client/enregistrement', 'CustomerAreaController@register'); //TODO
Route::get('/espace-client/profil', 'CustomerAreaController@profilPage'); //TODO
Route::get('/espace-client/commandes', 'CustomerAreaController@ordersPage'); //TODO
Route::get('/espace-client/commandes/{order}', 'OrderController@show'); //TODO
Route::get('/espace-client/adresses', 'CustomerAreaController@addressPage'); //TODO
/* ----------------*/

/**
* Dashboard
*/
Route::get('/dashboard', 'DashboardController@index'); //TODO
Route::get('/dashboard/commandes', 'DashboardController@orders'); //TODO
Route::get('/dashboard/commandes/{status}', 'DashboardController@orders'); //TODO
Route::get('/dashboard/produits', 'DashboardController@products'); //TODO
Route::get('/dashboard/produits/stocks', 'DashboardController@stocks'); //TODO
Route::get('/dashboard/produits/categories', 'DashboardController@categories'); //TODO
Route::get('/dashboard/produits/categories/rang/{category}/{rank}', 'CategoryController@updateRank');
Route::get('/dashboard/clients', 'DashboardController@customers'); //TODO
Route::get('/dashboard/clients/avis', 'DashboardController@reviews'); //TODO
Route::get('/dashboard/reductions', 'DashboardController@vouchers'); //TODO
Route::get('/dashboard/newsletter', 'DashboardController@newsletters'); //TODO

Route::get('/dashboard/switch_is_hidden_product/{product}', 'ProductController@switchIsHidden');
Route::get('/dashboard/switch_is_hidden_category/{category}', 'CategoryController@switchIsHidden');
/* ----------------*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
