<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AuthenticationCheck
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
        if (Session::get('admin_status') == 1 && Session::get('admin_level') == 0) {
            
            return $next($request);

        }else if(Session::get('admin_status') == 1 && Session::get('admin_level') == 1){

            return redirect('/admin/orders');

        }else{
            return redirect('/admin')->with(['error' => 'Silahkan Login Terlebih dahulu']);
        }
    }
}
