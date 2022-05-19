<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
        if (Auth::check() && Auth::user()->level == 'admin' || Auth::check() && Auth::user()->level == 'root') {
            return $next($request);
          }

        Alert::error('Oopss..', 'Unautorize to accses page.');
        return redirect('/');
    }
}
