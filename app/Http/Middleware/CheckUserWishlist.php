<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckUserWishlist
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
        if(Auth::check() && Auth::user()->wishlist_id == null){
            $wishlistController = new \App\Http\Controllers\WishListController();
            $wishlistController->store($request, Auth::user());
        }

        return $next($request);
    }
}
