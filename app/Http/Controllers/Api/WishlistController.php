<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index($id){
        try{
            $user=User::findOrFail($id);
            if($user){
                $wishlists = Wishlist::select('wishlists.*')
                ->selectSub(function ($query) {
                    $query->select('id') // Only select the 'id' column from products
                        ->from('products')
                        ->whereColumn('products.id', 'wishlists.prod_id')
                        ->limit(1);
                }, 'id_prod') // Alias the subquery result
                ->selectSub(function ($query) {
                    $query->select('id')
                        ->from('carts')
                        ->whereColumn('carts.product_id', 'wishlists.prod_id')
                        ->limit(1);
                }, 'cart_id')
                ->where('user_id', $user->id)
                ->with('product.sub_category.category')
                ->paginate(10);
                
                
                if(count($wishlists)>0){
                    return response()->json([
                        'exist' => true,
                        'wishlists'=>$wishlists
                    ]);
                }
                else{ 
                    return response()->json([
                        'exist' => false,
                        'message' => 'Products in wishlist Not found',
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
    public function destroy($id){
        try {
            $wishlist=Wishlist::findOrFail($id);
            if($wishlist){
                $wishlist->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted from wishlist',
                ]);
            }
            else return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        

    }
    public function store(Request $request){
        try {
            $form=$request->validate([
                'user_id'=> 'required|numeric|exists:users,id',
                'prod_id'=> 'required|numeric|exists:products,id',
            ]);
            Wishlist::create([
                'user_id'=>$form['user_id'],
                'prod_id'=>$form['prod_id'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product added in wishlist',
            ]);
        } 
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function count($userid){
        try{
            $count = Wishlist::where('user_id',$userid)->count();
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
}
