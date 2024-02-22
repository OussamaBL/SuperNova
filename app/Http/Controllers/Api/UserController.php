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
        // form validation
        $login=$request->validated();
        //login user
        $email=$this->validation_input($request->email);
        $password=$this->validation_input($request->password);
        if(auth()->attempt([
            'email'=> $email,
            'password'=>$password,
        ])){
        //login success
            $user = User::where('email', $email)->first();
            $token = $user->createToken('simple_user')->plainTextToken;
            return response()->json([
                'success' => true,
                'user' => [
                    'currentToken' => $token,
                    'data' => $user,
                    'role'=> $user->role()->name,
                ]
            ]); 
        }else{
            //login fail
            return response()->json([
                'success' => false,
                'message' => 'These credentials do not match any of our records.'
            ]);
        }
    }

    public function register(RegisterRequest $request){
        try {
            $form = $request->validated();
            $name=$this->validation_input($request->name);
            $email=$this->validation_input($request->email);
            $password=$this->validation_input($request->password);
            $password = Hash::make($password);
            $user = User::create([
                'name'=> $name,
                'email'=> $email,
                'password'=>$password,
            ]);
            auth()->login($user);

            $user = User::where('email', $email)->first();
            $token = $user->createToken('simple_user')->plainTextToken;
            return response()->json([
                'success' => true,
                'user' => [
                    'currentToken' => $token,
                    'data' => $user,
                    'role'=> $user->role()->name,
                ]
            ]);
        } catch (\Exception $e) {
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

                                                            
                                                        