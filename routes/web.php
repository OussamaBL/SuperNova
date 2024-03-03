<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
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
});

Route::get('/dashboard',function(){
    return view('back_office');
});
// Route::get('auth/authsocial_call/{provider}', [UserController::class, 'authsocial_call'])->name('authsocial_call')->middleware('web');
