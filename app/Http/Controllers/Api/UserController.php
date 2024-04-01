<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Pwdreset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepositorieInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class UserController extends Controller
{

    protected $UserRepositorieInterface;


    public function __construct(UserRepositorieInterface $UserRepositorieInterface){
        $this->UserRepositorieInterface = $UserRepositorieInterface;
    }
    

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
                $user =$this->UserRepositorieInterface->getByEmail($request->email);
                // $user = User::where('email', $request->email)->first();
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
            $user=$this->UserRepositorieInterface->create($form);
            // $user = User::create($form);
            $token = $user->createToken('simple_user')->plainTextToken;
            $user= $this->UserRepositorieInterface->getByEmail($request->email);
            // $user = User::where('email', $request->email)->first();
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

    public function mailer(){
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT');
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->isHTML(true);  
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        return $mail;
    }

    public function forget_password(Request $request){
       
            $form = $request->validate([
                'email' => 'required|max:255',
            ]);
            $user= $this->UserRepositorieInterface->getByEmail($request->email);
            // $user = User::where('email', $request->email)->first();
            if($user){
                try{
                    $mail=$this->mailer();
                    $token = bin2hex(random_bytes(32));
                    
                    $url="http://localhost:8000/#/new_password/".$token;
                    
                    $mail->addAddress($user->email,$user->name);
                    $mail->Subject = "Reset your password for SuperNova Gaming";
                    $mail->Body = '<html> <head></head>
                    <body>
                    <p> we recieved a password reset request. the link to reset your password is below.if you did not make this request, you can ignore this email </p>
                    <p>Here is your password reset link: </p> <br>
                    <a href="'.$url.'">'.$url.' </a> 
                    </body>
                    </html>';

                    // just for test until resolve the probleme of sweet retur error
                    Pwdreset::create([
                        "email"=>$user->email,
                        "token"=>$token,
                        "expires"=>date("U")+1800,
                    ]);

                    if($mail->send()){
                        // Pwdreset::create([
                        //     "email"=>$user->email,
                        //     "token"=>$token,
                        //     "expires"=>date("U")+1800,
                        // ]);
                        return response()->json([
                            'success' => true,
                            'message' => 'Check your email inbox !!'
                        ]);
                    }
                    else{
                        return response()->json([
                            'success' => false,
                            'message' => "Mail doesn't send. ".$mail->ErrorInfo
                        ]);
                    }
                }
                catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Send mail failed: ' . $e->getMessage()
                    ]);
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Email incorrect !!'
                ]);
            }
    }

    public function reset_password(Request $request){
        $form = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);
        $token = Pwdreset::where('token', $request->token)->where('expires', '>=', date('U'))->first();
        if($token){
            if($request->password==$request->confirm_password){
                // $user=User::where('email',$token->email)->first();
                $user= $this->UserRepositorieInterface->getByEmail($token->email);
                $token->delete();

                $user=$this->UserRepositorieInterface->update($user->id,['password'=>Hash::make($request->password)]);
                // $user->password= Hash::make($request->password);
                // $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Password updated successfully !!'
                ]);
            }
            else return response()->json([
                'success' => false,
                'message' => 'Invalid Confirmation of password !!'
            ]);
        } 
        else return response()->json([
            'success' => false,
            'message' => 'Token expired !!'
        ]);


    }
    public function verify_token(Request $request){
        $token = Pwdreset::where('token', $request->token)->where('expires', '>=', date('U'))->first();
        if($token) return response()->json([
                'success' => true,
                'message' => 'Token valid !!'
            ]);
        else return response()->json([
            'success' => false,
            'message' => 'Token expired !!'
        ]);
    }

    protected $providers = [ "google", "github", "facebook" ];

    # redirection vers le provider
    public function redirect (Request $request) {

        $provider = $request->provider;
        if (in_array($provider, $this->providers)) 
            // on envoye vers le provider
            return response()->json([
                'success'=>true,
                'message'=>'access to authenticate is valid',
                'redirect_url' => Socialite::driver($provider)->redirect()->getTargetUrl(),
            ]);
            // return Socialite::driver($provider)->redirect();
        else 
            // le provider n'est pas autorise
            return response()->json([
                'success'=>false,
                'message'=>'Network invalid',
            ]); 
    }

    // // Callback du provider
    // public function authsocial_call(Request $request) {
    //     // echo 'heeeloo';
    //     // try{
    //         $provider = $request->provider;
    //         if (in_array($provider, $this->providers)) {
    //             // informations d'utilisateur auth
    //             $data = Socialite::driver($request->provider)->user();
    //             // echo $provider;
    //             // $id = $data->getId();
    //             // $name = $data->getNickname();
    //             // $nickname = $data->getName();
    //             // $email = $data->getEmail();
    //             // $avatar = $data->getAvatar();
    
    //             // $user = User::where("email", $email)->first();
    //             // if($user){
    //             //     $user->name = $name;
    //             //     $user->nickname = $nickname;
    //             //     $user->avatar = $avatar;
    //             //     $user->save();
    //             // }
    //             // else{
    //             //     $user = User::create([
    //             //         'name' => $name,
    //             //         'nickname' => $nickname,
    //             //         'email' => $email,
    //             //         'avatar' => $avatar,
    //             //         'password' => bcrypt("emilie") // On attribue un mot de passe
    //             //     ]);
    //             //     $token = $user->createToken('simple_user')->plainTextToken;
    //             // }
    
    //             // return response()->json([
    //             //         'success' => true,
    //             //         'user' => [
    //             //             'currentToken' => $token,
    //             //             'data' => $user,
    //             //             'role'=> $user->role->name,
    //             //         ]
    //             //     ]); 
    //         }
    //         else{
    //             return response()->json([
    //                 'success'=>false,
    //                 'message'=>'Network invalid',
    //             ]); 
    //         }
    //     // }
    //     // catch (\Exception $e) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'Registration failed: ' . $e->getMessage()
    //     //     ]);
    //     // }
    // }
    public function update(Request $request,$id){
        try{
            $form=$request->validate([
                'name'=>'required|string',
                'email'=>'required|email|unique:users,email,'.$id.',id',
                'nickname'=>'nullable|string|unique:users,nickname,'.$id.',id',
                'sexe' => ['nullable', Rule::in(['male', 'female'])],
                'adress'=>'nullable|string',
                'city'=>'nullable|string',
                'country'=>'nullable|string',
                'tele'=>'nullable|string',
                'password'=>'required|min:6|max:255',
                'new_password'=>'nullable|min:6|max:255',
                'confirmation_password'=>'nullable|min:6|max:255',
            ]);
            $user=$this->UserRepositorieInterface->getById($id);
            if (Hash::check($form['password'], $user->password)) {
                $user->name=$form['name'];
                $user->email=$form['email'];
                $user->nickname=$form['nickname'];
                $user->sexe=$form['sexe'];
                $user->adress=$form['adress'];
                $user->city=$form['city'];
                $user->country=$form['country'];
                $user->tele=$form['tele'];
                if(isset($form['new_password'])){
                    if($form['new_password']==$form['confirmation_password']) 
                        $user->password=Hash::make($form['new_password']);
                }
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully',
                    'user'=> $user,
                ]);
            } 
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'Password incorrect'
                ]);
            }
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Profile updated failed: ' . $e->getMessage(),
            ]);
        }
       
    }
}

                                                            
                                                        