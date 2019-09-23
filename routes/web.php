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
Route::get('/espace-client', 'CustomerAreaController@index');
Route::get('/espace-client/connexion', 'CustomerAreaController@loginPage');
Route::post('/espace-client/connexion', 'CustomerAreaController@login');
Route::get('/espace-client/enregistrement', 'CustomerAreaController@registerPage');
Route::post('/espace-client/enregistrement', 'CustomerAreaController@register');
Route::get('/espace-client/profil', 'CustomerAreaController@profil');
Route::get('/espace-client/commandes', 'CustomerAreaController@orders');
Route::get('/espace-client/commandes/{order}', 'OrderController@show');
Route::get('/espace-client/adresses', 'CustomerAreaController@address');
/* ----------------*/

/**
* Dashboard
*/
Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/commandes', 'DashboardController@orders');
Route::get('/dashboard/commandes/{status}', 'DashboardController@orders')->withStatus($status);
Route::get('/dashboard/produits', 'DashboardController@products');
Route::get('/dashboard/produits/stocks', 'DashboardController@stocks');
Route::get('/dashboard/categories', 'DashboardController@categories');
Route::get('/dashboard/clients', 'DashboardController@customers');
Route::get('/dashboard/clients/avis', 'DashboardController@reviews');
Route::get('/dashboard/reductions', 'DashboardController@vouchers');
Route::get('/dashboard/newsletter', 'DashboardController@newsletters');
/* ----------------*/