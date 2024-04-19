<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
        $coupons=Coupon::all();
        if(count($coupons)>0) return response()->json([
            'exist' => true,
            'coupons'=>$coupons
        ]);
        else return response()->json([
            'exist' => false,
            'message' => 'Coupons not found',
        ]);
    }

    public function store(Request $request){
        try {
            
            $form=$request->validate([
                'code' => 'required|string|unique:coupons,code',
                'percentage' => 'required|integer',
                'expire' => 'required|date',
                'count_use' => 'required|integer',
            ]);
            $coupon=Coupon::where('code',$form['code'])->first();
            if(!$coupon){
                $coupon=Coupon::create($form);
                return response()->json([
                    'success' => true,
                    'message' => 'coupon added',
                    'coupon' => $coupon->code,
                ]);
            }
            else return response()->json([
                'success' => false,
                'message' => 'coupon already exist',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
        
    }
    public function destroy($coupon){
        try{
            $coupon=Coupon::find($coupon);
            $coupon->delete();
            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request,$id){
        try{
            $form=$request->validate([
                'code' => 'required|string|unique:coupons,code,' . $id . ',id',
                'percentage' => 'required|integer',
                'expire' => 'required|date',
                'count_use' => 'required|integer',
            ]);
            $coupon=Coupon::find($id);
            $coupon->code=$form['code'];
            $coupon->percentage=$form['percentage'];
            $coupon->expire=$form['expire'];
            $coupon->count_use=$form['count_use'];
            $coupon->save();
            return response()->json([
                'success' => true,
                'message' => 'Coupon updated',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function verify(Request $request){
        try {
            $coupon=Coupon::where('code',$request->coupon)->firstOrFail();
            if($coupon){
                if($coupon->count_use>0){
                    if ($coupon->expire < now()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Coupon has expired',
                        ]);
                    }
                    else{
                        return response()->json([
                            'success' => true,
                            'percentage' => $coupon->percentage,
                        ]);
                    }
                }
                else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Complete number of uses',
                    ]);
                }
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Code not found',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
            ]);
        }
    }
}
