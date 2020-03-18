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
        if (\App\Admin::check()){
            return $next($request);
        }

        return redirect(route('admin.login'));
    }
}
