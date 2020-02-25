<?php

namespace App\Http\Middleware;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;

class Admin
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
        if (Auth::check() && Auth::user()->isAdmin){
            return $next($request);
        }

        return abort(401, "Vous n'êtes pas authorisé à voir cela.");
    }
}
