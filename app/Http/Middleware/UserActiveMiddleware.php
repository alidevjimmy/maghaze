<?php

namespace App\Http\Middleware;

use Closure;

class UserActiveMiddleware
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
        if (auth('api')->check()) {
            if (auth('api')->user()->active == true) {
                return $next($request);
            }
        }

    }
}
