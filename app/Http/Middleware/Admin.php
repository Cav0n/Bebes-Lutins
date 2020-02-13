<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Verify is the user is an Admin
 */
class Admin
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
        session(['returnTo' => url()->current()]);
        if(Auth::check() && Auth::user()->isAdmin){
            return $next($request);
        } else return redirect('/espace-client/connexion');
    }
}
