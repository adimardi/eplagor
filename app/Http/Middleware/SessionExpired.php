<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Session\Store;
use Auth;
use Cache;
use Session;
 
class SessionExpired {
    protected $session;
    protected $timeout = 60 * 60 ;
     
    public function __construct(Store $session){
        $this->session = $session;
    }
    public function handle($request, Closure $next){
        if(session('lastActivityTime')){
            if(time() - $this->session->get('lastActivityTime') > $this->timeout){
                Session::forget(['lastActivityTime', 'password_hash']);
                cache::forget('user-is-online-'.Auth::user()->id);
                auth()->logout();
            }
        }
        
        return $next($request);
    }
}