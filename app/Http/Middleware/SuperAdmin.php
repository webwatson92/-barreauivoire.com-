<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        
        $userRole = Auth::user()->role;

        if($userRole == "superadmin"){
            return $next($request);
        }else if($userRole == "admin"){
            return redirect()->route('admin');
        }else if($userRole == "barreau"){
            return redirect()->route('barreau');
        }else if($userRole == "avocat"){
            return redirect()->route('avocat');
        }else{
            return redirect()->route('admin.home');
        }

    }
}
