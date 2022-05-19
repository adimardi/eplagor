<?php
namespace App\Http\Middleware;
use App\Users;
use Closure;
use Auth;
use Session;
use Cache;
use Carbon\Carbon;

class ActivityByUser
{
    protected $session;


    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(10); // keep online for 10 min
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            Session::put('lastActivityTime', time());
            // last seen
            Users::where('id', Auth::user()->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }

        return $next($request);
    }
}