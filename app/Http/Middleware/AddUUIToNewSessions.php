<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddUUIToNewSessions
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
        if(!session()->has('uuid')){
            session()->put('uuid',\Str::uuid()->toString());
        }

        return $next($request);
    }
}
