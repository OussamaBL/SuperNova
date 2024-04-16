<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WishlistController;
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
    Route::get('product/popular/{user}', [ProductController::class, 'popular']);

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
    Route::get('sub_category/show/{subCategory}', [SubCategoryController::class, 'show']);
    Route::delete('sub_category/destroy/{sub_category}', [SubCategoryController::class, 'destroy']);
    Route::post('sub_category/update/{sub_category}', [SubCategoryController::class, 'update']);

// product
    Route::post('product/store', [ProductController::class, 'store']);
    Route::get('product/index', [ProductController::class, 'index']);
    Route::get('product/show/{product}/{userid}', [ProductController::class, 'show']);
    Route::delete('product/destroy/{product}', [ProductController::class, 'destroy']);
    Route::post('product/update/{product}', [ProductController::class, 'update']);

// sub categories of category
    Route::get('category/sub_categories/{category}', [SubCategoryController::class, 'getSubCategories']);

// get product of sub-cateogory
Route::get('products/subCategory/{subCategory}/{userid}', [ProductController::class, 'getProducts_SubCategory']);

// get the categories with sub-categories
Route::get('category/subcategories', [CategoryController::class, 'getCategory_Subcategories']);

// get products filter by selected option
Route::get('products/filter/{subCategory}/{option}', [ProductController::class, 'getProducts_filter']);

// get related Products
Route::get('products/related/{subCategory}/{product}/{userid}', [ProductController::class, 'getRelated_Products']);

// Wishlist
Route::get('wishlist/count/{user}', [WishlistController::class, 'count']);
Route::get('products/wishlist/{user}', [WishlistController::class, 'index']);
Route::delete('products/wishlist/destroy/{wishlist}', [WishlistController::class, 'destroy']);
Route::post('products/wishlist/store', [WishlistController::class, 'store']);

// Cart
Route::post('products/cart/store', [CartController::class, 'store']);
Route::delete('products/cart/destroy/{cart}', [CartController::class, 'destroy']);
Route::get('cart/count/{user}', [CartController::class, 'count']);
Route::get('products/cart/{user}', [CartController::class, 'index']); 

// payment
Route::get('/payments/{user}', [PaymentController::class, 'get_payments']);
Route::get('order/products/{order}', [PaymentController::class, 'get_orders']);



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


           