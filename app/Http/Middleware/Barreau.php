<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Barreau
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
        
        if($userRole == "barreau"){
            return $next($request);
        }else if($userRole == "admin"){
            return redirect()->route('admin');
        }else if($userRole == "superadmin"){
            return redirect()->route('superadmin');
        }else if($userRole == "avocat"){
            return redirect()->route('avocat');
        }else{
            return redirect()->route('admin.home');
        }
    }
}
