<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if(auth()->check() && $user->two_factor_code){
            $expiresAt = Carbon::parse($user->two_factor_expires_at);
            if($expiresAt->lt(now())){
                $user->resetTwoFactorCode();
                auth()->logout();
                return redirect()->route('login')->withMessage('Le code a expiré. SVP connectez-vous !');
            }
            if(!$request->is('verify*')){
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}
