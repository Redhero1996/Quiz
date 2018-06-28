<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

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
        if( Auth::check() && (Auth::user()->level == 1 )){
            return $next($request);
        }else{
            return redirect('admin/login')->with('error', 'You have not admin access');
        }
        
    }
}
