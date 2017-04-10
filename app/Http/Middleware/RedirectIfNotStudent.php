<?php

namespace App\Http\Middleware;

use Closure;
use \Session;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'student')
    {
        if(!Auth::guard($guard)->check()){
            Session::flash('error', 'Nie masz dostępu do tej sekcji.');
            return redirect()->back();
        }

        return $next($request);
    }
}
