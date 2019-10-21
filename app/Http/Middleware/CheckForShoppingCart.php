<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon;
use App\Order;
use App\ShoppingCart;

class CheckForShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // 1 - Verifier si il y a bien un panier dans la session
        // Si il n'y a pas de panier on en crée un
        // 2 - On vérifie si l'utilisateur est connecté
        // Si il n'est pas connecté on arrete et on renvoie la requête
        // 3 - Si l'utilisateur est connecté on regarde le nombre d'items dans le panier
        // Si le nombre d'items est > à 0
        // 4 - Si le nombre est = à 0 on recherche un panier actif avec le nom de l'utilisateur
        // 5 - Si on trouve un panier actif on met le panier actuel en non actif

        $shopping_cart = $request->session()->get('shopping_cart');

        if($shopping_cart != null){
            if(Auth::check()){
                if($shopping_cart->user == null){
                    if(count($shopping_cart->items) > 0){
                        $shopping_cart->user_id = Auth::user()->id;
                        $shopping_cart->save();
                        $request->session()->put('shopping_cart', $shopping_cart);
                    } else {
                        if(ShoppingCart::where('user_id', Auth::user()->id)->where('isActive', 1)->exists()){
                            $shopping_cart->isActive = false;
                            $shopping_cart->save();
                            
                            $shopping_cart = ShoppingCart::where('user_id', Auth::user()->id)->where('isActive', 1)->first();
                            $request->session()->put('shopping_cart', $shopping_cart);
                        } else {
                            $shopping_cart->user_id = Auth::user()->id;
                            $shopping_cart->save();
                            $request->session()->put('shopping_cart', $shopping_cart);
                        }
                    }
                }
            }
        }

        if($shopping_cart == null){
            if(Auth::check()){
                if(ShoppingCart::where('user_id', Auth::user()->id)->where('isActive', 1)->exists()){
                    $shopping_cart = ShoppingCart::where('user_id', Auth::user()->id)->where('isActive', 1)->first();
                    $request->session()->put('shopping_cart', $shopping_cart);
                }
            }
        }

        if($shopping_cart == null){
            $shopping_cart = new ShoppingCart();
            $shopping_cart->id = uniqid();
            $shopping_cart->isActive = true;
            if(Auth::check()) $shopping_cart->user_id = auth::user()->id;
            $shopping_cart->save();
            $request->session()->put('shopping_cart', $shopping_cart);
        }

        if($shopping_cart->voucher != null){
            $this->verifyVoucher($shopping_cart->voucher);
        }

        if($shopping_cart->items != null){
            $this->verifyProductsAvailability($request, $shopping_cart);
        }

        return $next($request);
    }

    public function verifyProductsAvailability($request, ShoppingCart $shopping_cart){
        foreach($shopping_cart->items as $item){
            if($item->product->isHidden == 1) {
                $item->delete();
                $request->session()->put('shopping_cart_infos', 'Un ou plusieurs produits qui étaient dans votre panier ne sont plus disponibles.');
            }
            if($item->product->isDeleted == 1) {
                $item->delete();
                $request->session()->put('shopping_cart_infos', 'Un ou plusieurs produits qui étaient dans votre panier ne sont plus disponibles.');
            }
        }

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();

        session(['shopping_cart' => $shopping_cart]);
    }

    public function verifyVoucher($voucher){
        $shopping_cart = session('shopping_cart');
        $unvalidated = false;

        // FIRST DATE IS IN THE FUTUR ?
        if($voucher->dateFirst > Carbon\Carbon::now()){
            $unvalidated = true;
        }

        // LAST DATE IS IN THE PAST ?
        if($voucher->dateLast < Carbon\Carbon::now()){
            $unvalidated = true;
        }

        // SHOPPING CART MINIMAL PRICE IS OK ?
        if($shopping_cart->productsPrice < $voucher->minimalPrice){
            $unvalidated = true;
        }

        $usage_number = Order::where('voucher_id', $voucher->id)->where('user_id', $shopping_cart->user_id)->count();

        // NUMBER OF USAGE FOR CURRENT CUSTOMER
        if($usage_number >= $voucher->maxUsage){
            $unvalidated = true;
        }

        if($unvalidated == false){
            // IF DISCOUNT TYPE IS %
            if($voucher->discountType == 1){
                // PRODUCTS ID OF THE VOUCHER (AUTHORIZED / FORBIDDEN)
                $productid_voucher_list = array();
                foreach($voucher->products as $product){
                    $productid_voucher_list[] = $product->id;
                }
                
                // CATEGORIES ID OF THE VOUCHER (AUTHORIZED / FORBIDDEN)
                $categoriesid_voucher_list = array();
                foreach($voucher->categories as $category){
                    $categoriesid_voucher_list[] = $category->id;
                }
                
                switch($voucher->availability){
                    case 'allProducts': // AVAILABLE ON ALL PRODUCTS EXCEPTS ...
                    foreach($shopping_cart->items as $item){
                        $item->hasReduction = 1;
                        if(in_array($item->product->id, $productid_voucher_list)){
                            $item->hasReduction = 0;
                        }
                        $item->save();
                    }
                    break;

                    case 'certainProducts': // AVAILABLE ON ONLY CERTAIN PRODUCTS
                    foreach($shopping_cart->items as $item){
                        $item->hasReduction = 0;
                        if(in_array($item->product->id, $productid_voucher_list)){
                            $item->hasReduction = 1;
                        }
                        $item->save();
                    }
                    break;

                    case 'certainCategories': // AVAILABLE ON CERTAIN CATEGORIES
                    foreach($shopping_cart->items as $item){
                        $item->hasRedution = 0;
                        $item->save();
                        foreach($item->product->categories as $category){
                            while($category->parent != null){
                                if(in_array($category->id, $categoriesid_voucher_list)){
                                    $item->hasRedution = 1;
                                    $item->save();
                                    break;
                                } else $category = $category->parent;
                            }
                        }
                    }
                    break;

                    case 'allCategories': // AVAILABLE ON ALL CATEGORIES EXCEPTS...
                    foreach($shopping_cart->items as $item){
                        $item->hasRedution = 1;
                        $item->save();
                        foreach($item->product->categories as $category){
                            while($category->parent != null){
                                if(in_array($category->id, $categoriesid_voucher_list)){
                                    $item->hasRedution = 0;
                                    $item->save();
                                    break;
                                } else $category = $category->parent;
                            }
                        }
                    }
                    break;
                }
            }

            // IF VOUCHER IS "FREE SHIPPING" AND SHOPPING CART PRICE > 70€
            // THEN VOUCHER IS NOT NEEDED BECAUSE SHIPPING IS ALREADY FREE
            if($voucher->discountType == 3 && $shopping_cart->productsPrice > 70){
                // $response_array['status'] = 'error'; 
                // $response_array['message'] = "Vous bénéficiez déjà de la livraison gratuite."; 
                // echo json_encode($response_array, JSON_PRETTY_PRINT);
                return;
            }

            //UPDATE SHOPPING CART WITH VOUCHER
            $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
            $shopping_cart->voucher_id = $voucher->id;
            $shopping_cart->save();

            $shopping_cart->updateProductsPrice();
            $shopping_cart->updateShippingPrice();
            $shopping_cart->save();

            session(['shopping_cart' => $shopping_cart]);
        } else {
            $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
            $shopping_cart->voucher_id = null;
            $shopping_cart->save();
            $shopping_cart->updateProductsPrice();
            $shopping_cart->updateShippingPrice();
            $shopping_cart->save();
        }
    }
}
