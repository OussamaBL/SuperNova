<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function auth(LoginRequest $request){
        try{
            // form validation
            $login=$request->validated();
            //login user
            if(auth()->attempt([
                'email'=> $request->email,
                'password'=>$request->password,
            ])){
            // login success
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('simple_user')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'user' => [
                        'currentToken' => $token,
                        'data' => $user,
                        'role'=> $user->role->name,
                    ]
                ]); 
            }
            else{
                //login fail
                return response()->json([
                    'success' => false,
                    'message' => 'Email or password incorrect !!'
                ]);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
        }
    }

    public function register(RegisterRequest $request){
        try {
            $form = $request->validated();

            $form['password'] = Hash::make($form['password']);
            $user = User::create($form);
            $token = $user->createToken('simple_user')->plainTextToken;
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'success' => true,
                'user' => [
                    'currentToken' => $token,
                    'data' => $user,
                    'role'=> $user->role->name,
                ]
            ]); 
        } 
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}

                                                            
                                                        