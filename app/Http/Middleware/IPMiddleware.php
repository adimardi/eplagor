<?php

namespace App\Http\Middleware;

use Closure;

class IPMiddleware
{
    public $whiteIps = ['::1','172.16.20.116'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->ip(), $this->whiteIps)) {
    
            /*
                 You can redirect to any error page. 
            */
            return response()->json(['your ip address is not valid.']);
        }
    
        return $next($request);

    }
}
