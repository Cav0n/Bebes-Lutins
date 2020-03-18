<?php

namespace App\Http\Middleware;

use Closure;

class SessionCartUpdate
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
        $shoppingCart = session()->get('shopping_cart');

        $updatedShoppingCart = \App\Cart::where('id', $shoppingCart->id)->first();

        session()->put('shopping_cart', $updatedShoppingCart);

        return $next($request);
    }
}
