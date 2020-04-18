<?php

namespace App\Http\Middleware;

use Closure;
use \App\VisitorLog;
use Illuminate\Support\Facades\Request;

class LogVisitor
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
        if (!Request::is('admin/*') && !Request::is('api/*')){
            VisitorLog::log();
        }

        return $next($request);
    }
}
