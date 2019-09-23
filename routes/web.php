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
Route::get('/produits/{category}/{product}', 'ProductController@show');
/* ----------------*/
