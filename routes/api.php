<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ProductController;
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

// popular product
    Route::get('product/popular', [ProductController::class, 'popular']);

// Update profile
    Route::put('profile/update/{user}', [UserController::class, 'update']);

// categories
    Route::get('category/index', [CategoryController::class, 'index']);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy']);
    Route::put('category/update/{category}', [CategoryController::class, 'update']);

// sub-categories
    Route::post('sub_category/store', [SubCategoryController::class, 'store']);
    Route::get('sub_category/index', [SubCategoryController::class, 'index']);
    Route::delete('sub_category/destroy/{sub_category}', [SubCategoryController::class, 'destroy']);
    Route::post('sub_category/update/{sub_category}', [SubCategoryController::class, 'update']);

// product
    Route::post('product/store', [ProductController::class, 'store']);
    Route::get('product/index', [ProductController::class, 'index']);
    Route::delete('product/destroy/{product}', [ProductController::class, 'destroy']);
    Route::post('product/update/{product}', [ProductController::class, 'update']);

// sub categories of category
    Route::get('category/sub_categories/{category}', [SubCategoryController::class, 'getSubCategories']);

// get product of sub-cateogory
Route::get('products/subCategory/{subCategory}', [ProductController::class, 'getProducts_SubCategory']);





    
Route::post('login', [UserController::class, 'auth'])->name('login');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('forget_password', [UserController::class, 'forget_password'])->name('forget_password');
Route::post('reset_password', [UserController::class, 'reset_password'])->name('reset_password');
Route::post('verify_token', [UserController::class, 'verify_token'])->name('verify_token');



Route::get('auth/redirect/{provider}', [UserController::class, 'redirect'])->name('redirect')->middleware('web');
Route::get('auth/authsocial_call/{provider}', [UserController::class, 'authsocial_call'])->name('authsocial_call')->middleware('web');
// Route::get('/auth/authsocial_call/{provider}', function () {
    
 
//     return redirect('/dashboard');
// });


           