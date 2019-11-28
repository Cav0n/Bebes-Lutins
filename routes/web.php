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
Route::get('/tests/mail', 'PageController@test_mail');
Route::get('/tests/mail_ui', 'PageController@test_mail_ui');
Route::get('/commandes/{order}', 'PageController@bill');

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
Route::post('/espace-client/ma-liste-d-envie/ajout-produit/{product}', 'WishListItemController@store');
Route::delete('/espace-client/ma-liste-d-envie/retirer-produit/{product}', 'WishListItemController@destroy');
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
Route::post('/panier/add_item', 'ShoppingCartItemController@checkIfProductAlreadyInShoppingCart');
Route::post('/panier/change_quantity/{shoppingCartItem}', 'ShoppingCartItemController@updateQuantityOnly');
Route::delete('/panier/remove_item/{shoppingCartItem}', 'ShoppingCartItemController@destroy');
Route::post('/panier/code-coupon/ajouter', 'ShoppingCartController@addVoucher');
Route::post('/panier/code-coupon/supprimer', 'ShoppingCartController@removeVoucher');
Route::post('/panier/ajout_message/{shopping_cart}', 'ShoppingCartController@update');

Route::get('/panier/livraison', 'ShoppingCartController@showDelivery');
Route::post('/panier/livraison/validation', 'ShoppingCartController@validateDelivery');

Route::get('/panier/paiement', 'ShoppingCartController@showPayment');
Route::get('/panier/paiement/carte-bancaire', 'ShoppingCartController@showCreditCardPayment');

Route::get('/panier/paiement/validation/cheque', 'ShoppingCartController@validateChequePayment');
Route::get('/panier/paiement/validation/carte-bancaire', 'ShoppingCartController@validateCreditCartPayment');
Route::get('/merci', 'OrderController@showThanks');
Route::get('/panier/paiement/erreur', 'OrderController@showErrorPayment');
//PAYMENT 
Route::get('/cancel_payment/{order}', 'PaymentController@cancel');
Route::get('/notification_payment/{order}', 'PaymentController@notification');
Route::get('/payment_endpoint/{order}', 'PaymentController@endPoint');

Route::get('/paiement-annule', 'PageController@canceledPayment');
Route::get('/merci', 'PageController@successPayment');

 /* ---------------- */

/**
 * Customer area
 */
Auth::routes();

Route::get('/espace-client', 'CustomerAreaController@index'); //TODO
Route::get('/espace-client/connexion', 'CustomerAreaController@loginPage')->name('connexion'); //TODO
Route::post('/espace-client/connexion', 'CustomerAreaController@login')->name('connexion'); //TODO
Route::post('/espace-client/reinitialiser-mot-de-passe', 'CustomerController@resetPassword');

Route::get('/espace-client/mot-de-passe-oublie', 'CustomerAreaController@resetPasswordPage');
Route::post('/espace-client/generer-code-reinitialisation', 'CustomerController@resetPasswordCode');
Route::post('/espace-client/verifier-code-reinitialisation', 'CustomerController@verifyResetCode');

Route::get('/espace-client/enregistrement', 'CustomerAreaController@registerPage'); //TODO
Route::post('/espace-client/enregistrement', 'CustomerAreaController@register'); //TODO

Route::get('/espace-client/profil', 'CustomerAreaController@profilPage'); //TODO
Route::post('/espace-client/profil/modifier-informations', 'CustomerController@update');
Route::post('/espace-client/profil/modifier-mot-de-passe', 'CustomerController@updatePasswordOnly');
Route::post('/espace-client/newsletter-invert', 'CustomerAreaController@invertNewsletter');
Route::get('/espace-client/commandes', 'CustomerAreaController@ordersPage'); //TODO
Route::get('/espace-client/commandes/{order}', 'OrderController@show'); //TODO
Route::post('/commandes/{order}', 'OrderController@getJSON');
Route::get('/espace-client/ma-liste-d-envie', 'WishListController@show');
Route::post('/liste-envie/verifier-produit', 'WishListItemController@checkIfProductIsInWishlist');

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
Route::get('/dashboard/commandes/fiche/{order}', 'OrderController@show');
Route::post('/dashboard/commandes/recherche', 'OrderController@search');
//PRODUCTS
Route::get('/dashboard/produits', 'DashboardController@products'); //TODO
Route::get('/dashboard/produits/nouveau', 'ProductController@create');
Route::post('/dashboard/produits/nouveau', 'ProductController@store');
Route::get('/dashboard/produits/edition/{product}', 'ProductController@edit');
Route::post('/dashboard/produits/edition/{product}', 'ProductController@update');
Route::get('/dashboard/produits/stocks', 'DashboardController@stocks'); //TODO
Route::get('/dashboard/produits/mis-en-avant', 'DashboardController@highlighted'); //TODO
Route::post('/dashboard/produits/mis-en-avant', 'ProductController@highlightProducts');
Route::post('/dashboard/produits/mis-en-avant/enlever/{product}', 'ProductController@highlightProductsRemove');
Route::delete('/dashboard/produits/supprimer/{product}', 'ProductController@destroy');
Route::get('/dashboard/produits/correction-images', 'ProductController@correctAllMainImages');
Route::post('/dashboard/produits/recherche', 'ProductController@search');
Route::post('/dashboard/produits/trier-par-categorie/{category}', 'ProductController@searchWithCategory');
//CATEGORIES
Route::get('/dashboard/produits/categories', 'DashboardController@categories'); //TODO
Route::get('/dashboard/produits/categories/nouvelle', 'CategoryController@create');
Route::post('/dashboard/produits/categories/nouvelle', 'CategoryController@store');
Route::get('/dashboard/produits/categories/edition/{category}', 'CategoryController@edit');
Route::post('/dashboard/produits/categories/edition/{category}', 'CategoryController@update');
Route::get('/dashboard/produits/categories/rang/{category}/{rank}', 'CategoryController@updateRank');
Route::get('/dashboard/switch_is_hidden_product/{product}', 'ProductController@switchIsHidden');
Route::get('/dashboard/switch_is_hidden_category/{category}', 'CategoryController@switchIsHidden');
Route::post('/dashboard/categories/recherche', 'CategoryController@search');
//CUSTOMERS
Route::get('/dashboard/clients', 'DashboardController@customers'); //TODO
Route::get('/dashboard/clients/avis', 'DashboardController@reviews');
Route::get('/dashboard/clients/avis/{review}', 'ReviewController@show');
Route::post('/dashboard/clients/avis/repondre/{review}', 'ReviewController@update');
Route::post('/dashboard/clients/avis/supprimer-reponse/{review}','ReviewController@update');
Route::get('/dashboard/clients/fiche/{user}', "DashboardController@customer");
Route::post('/dashboard/clients/recherche', "CustomerController@search");
Route::get('/dashboard/clients/messages', "MessageController@index");
//OTHERS
Route::get('/dashboard/reductions', 'DashboardController@vouchers'); //TODO
Route::get('/dashboard/reductions/nouveau', 'VoucherController@create'); //TODO
Route::post('/dashboard/reductions/nouveau', 'VoucherController@store');
Route::get('/dashboard/reductions/edition/{voucher}', 'VoucherController@edit');
Route::post('/dashboard/reductions/edition/{voucher}', 'VoucherController@update');
Route::get('/dashboard/newsletter', 'DashboardController@newsletters'); //TODO
Route::get('/dashboard/analyses', 'DashboardController@analytics');
Route::post('/dashboard/analyses/calculate_turnover', 'TurnoverCalculatorController@calculateCustomTurnover');
Route::post('/dashboard/analyses/calculate_all', 'TurnoverCalculatorController@calculateAll');

Route::post('/upload_image', 'ImageController@store');
Route::delete('/delete_image', 'ImageController@destroy');
/* ---------------- */

/**
 * UTILS
 */
Route::post('/addresses/{address}', 'AddressController@get');
Route::post('/know_thanks_to/add', 'OrderController@addKnowThanksTo');
Route::post('/images/upload', 'ImageController@upload');
 /* ---------------- */

 /**
  * STATICS
  */
Route::get('/contact', 'MessageController@create');
Route::post('contact/envoie-message', 'MessageController@store');

//EN SAVOIR PLUS
Route::get('/en-savoir-plus/qui-sommes-nous', 'StaticPageController@who');
Route::get('/en-savoir-plus/pourquoi-les-couches-lavables', 'StaticPageController@why');
Route::get('/en-savoir-plus/entretien-des-couches-lavables', 'StaticPageController@maintenance');
Route::get('/en-savoir-plus/mode-d-emploi', 'StaticPageController@manual');
Route::get('/en-savoir-plus/comment-s-equiper', 'StaticPageController@how');
Route::get('/en-savoir-plus/nos-revendeurs', 'StaticPageController@resellers');
Route::get('/en-savoir-plus/guide-et-conseils', 'StaticPageController@guide_and_tips');

//INFOS PRATIQUES
Route::get('/infos-pratiques/livraison-et-frais-de-ports', 'StaticPageController@shipping');
Route::get('/infos-pratiques/paiement', 'StaticPageController@payment');
Route::get('/infos-pratiques/echanges-et-retours', 'StaticPageController@return');
Route::get('/infos-pratiques/mentions-legales', 'StaticPageController@legal_notice');
Route::get('/infos-pratiques/conditions-de-ventes', 'StaticPageController@terms_of_sales');

