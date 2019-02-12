<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
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
        //pre(1);
        if(!session('user')){
            return redirect('admin/login');
//            return redirect('admin')->action('LoginController@login');   
        }

        return $next($request);
    }
}
