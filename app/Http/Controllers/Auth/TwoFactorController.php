<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\TwoFactor;
use App\Notifications\TwoFactorCode;
use Auth;

class TwoFactorController extends Controller
{
    public function __contruct(){
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.two-factor-code.authentification_code');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();
        $userRole = auth()->user()->role;

        if($request->input('two_factor_code') == $user->two_factor_code){
            $user->resetTwoFactorCode();

            switch ($userRole) {
                case 'superadmin':
                    return redirect()->route('superadmin');
                    break;
                case 'admin':
                    return redirect()->route('admin');
                    break;
                case 'barreau':
                    return redirect()->route('barreau');
                    break;
                case 'avocat':
                    return redirect()->route('avocat');
                    break;
                default:
                    return redirect()->route('admin.home');
                    break;
                }
        }
        return redirect()->back()->withErrors(['two_factor_code' => "Code d'\authentification incorrect !"]);
    }

    /**
     * Display the specified resource.
     */
    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        // $user->notify(new TwoFactorCode());

        return redirect()->back()->withMessage('Code d\'authentification renvoyé dans votre messagerie');
    }

    
}
