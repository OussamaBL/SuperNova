<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SocialiteController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('logout', [UserController::class, 'logout']);
});

Route::post('login', [UserController::class, 'auth'])->name('login');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('forget_password', [UserController::class, 'forget_password'])->name('forget_password');
Route::post('reset_password', [UserController::class, 'reset_password'])->name('reset_password');
Route::post('verify_token', [UserController::class, 'verify_token'])->name('verify_token');


Route::get('auth/redirect/{provider}', [UserController::class, 'redirect'])->name('redirect')->middleware('web');
Route::get('auth/authsocial_call/{provider}', [UserController::class, 'authsocial_call'])->name('authsocial_call')->middleware('web');



           