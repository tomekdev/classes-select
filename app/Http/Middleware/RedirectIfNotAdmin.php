<?php
/**
 * Created by PhpStorm.
 * User: MrBlue2583
 * Date: 03.04.2017
 * Time: 23:17
 */

namespace App\Http\Middleware;

use Closure;
use \Session;
use Illuminate\Support\Facades\Auth;



class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if(!Auth::guard($guard)->check()){
            Session::flash('error', 'Nie masz dostępu do tej sekcji.');
            return redirect()->back();
        }

        return $next($request);
    }
}