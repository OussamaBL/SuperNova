<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index($userid){
        try{
            $user=User::findOrFail($userid);
            if($user){
                $carts=Cart::where('user_id',$user->id)->with('product.sub_category.category')->get();
                if(count($carts)>0){
                    return response()->json([
                        'exist' => true,
                        'carts'=>$carts
                    ]);
                }
                else{ 
                    return response()->json([
                        'exist' => false,
                        'message' => 'Products in Cart Not found',
                    ]);  
                }
            }
            else{
                return response()->json([
                    'exist' => false,
                    'message' => 'User Not found',
                ]); 
            }
        }
        catch(Exception $e){
            return response()->json([
                'exist' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
  
    public function count($userid){
        try{
            $count = Cart::where('user_id',$userid)->count();
            if($count>0)
                return response()->json([
                    'success' => true,
                    'count' => $count,
                ]);
            else 
                return response()->json([
                    'success' => true,
                    'count' => 0,
                ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $form=$request->validate([
                'user_id'=> 'required|numeric|exists:users,id',
                'product_id'=> 'required|numeric|exists:products,id',
            ]);
            Cart::create([
                'user_id'=>$form['user_id'],
                'product_id'=>$form['product_id'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product added in the cart',
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id){
        try {
            $cart=Cart::findOrFail($id);
            if($cart){
                $cart->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted from the cart',
                ]);
            }
            else return response()->json([
                'success' => false,
                'message' => 'Product not found in cart',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        

    }
}
