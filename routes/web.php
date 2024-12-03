<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialAuthController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/auth/google/redirect', function (Request $request) {
//     return Socialite::driver('google')->redirect();
// });

// Route::get('/auth/google/callback', function (Request $request) {
//     dd($request->all());
// });

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
