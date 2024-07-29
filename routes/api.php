<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register')->name('register.api');
    Route::post('login', 'login')->name('login.api');;
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});