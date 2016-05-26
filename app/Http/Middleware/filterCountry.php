<?php

namespace tiens\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class filterCountry
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
                
        if(Auth::user()->rol_id==3)
            return Redirect::to('/');

        if(Auth::user()->rol_id==2 && (Auth::user()->country_id!=Auth::user()->country_id_admin))
        {
            return Redirect::to('/');            
        }

        return $next($request);
    }
}
