<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
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
                    $shopping_cart->isActive = false;
                    $shopping_cart->save();

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

        return $next($request);
    }
}
