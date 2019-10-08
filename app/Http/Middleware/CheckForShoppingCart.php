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
        $shopping_cart = $request->session()->get('shopping_cart');

        if($shopping_cart != null){
            if(Auth::check()){
                if(count($shopping_cart->items) == 0){
                    $shopping_cart = ShoppingCart::where('user_id', Auth::user()->id)->first();
                    $request->session()->put('shopping_cart', $shopping_cart);
                    return $next($request);
                }

                $shopping_cart->user_id = auth::user()->id;
                $shopping_cart->save();
                $request->session()->put('shopping_cart', $shopping_cart);
            }
            return $next($request);
        }

        $shopping_cart = new ShoppingCart();
        $shopping_cart->id = uniqid();
        $shopping_cart->isActive = true;
        if(Auth::check()) $shopping_cart->user_id = auth::user()->id;
        $shopping_cart->save();
        
        $request->session()->put('shopping_cart', $shopping_cart);
        return $next($request);
    }
}
