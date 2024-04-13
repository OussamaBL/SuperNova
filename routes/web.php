<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('front_office');
})->name('home');

Route::get('/dashboard',function(){
    return view('back_office');
});

Route::post('/checkout', [PaymentController::class, 'createSession'])->name('checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('success.payment');

// Route::get('/auth/authsocial_call/{provider}', [UserController::class, 'authsocial_call'])->name('authsocial_call')->middleware('web');
Route::get('/auth/authsocial_call/{provider}', function () {
    $user = Socialite::driver('google')->user();
    echo $user->name;
    // $user->token
});