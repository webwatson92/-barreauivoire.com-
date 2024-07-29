<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthentificationCode extends BaseController
{
    public function index(){
        return view('front.two-fator-code.authentification_code');
    }
}
