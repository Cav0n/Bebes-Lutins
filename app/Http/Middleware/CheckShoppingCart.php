<?php

namespace App\Http\Middleware;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;

class CheckShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        session()->get('shopping_cart', function(){

            $user = null;

            if(Auth::check()) $user = Auth::user();

            (new \App\Http\Controllers\CartController)->create($user, session()->getId());
        });

        return $next($request);
    }
}
