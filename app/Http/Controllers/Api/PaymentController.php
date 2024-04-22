<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{

    public function createSession(Request $request)
    {
        DB::beginTransaction();
        try{
            // dd($request->subtotal);
            $order_total=$request->subtotal;
            $order_total_number = number_format($order_total, 2);
            $decimal_num_dec = str_replace(',', '', $order_total_number);
            // dd($decimal_num_dec);
            $unit_amount_cents = (int) ($decimal_num_dec * 100);

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => "Test Payment",
                    ],
                    'unit_amount' => $unit_amount_cents,
                ],
                'quantity' => 1,
            ];
    
            // Create a checkout session with Stripe
            $session = Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('success.payment', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            ]);

            session_start();
            session()->put('products',$request->products);
            session()->put('subtotal',$decimal_num_dec);
            session()->put('user_id',$request->user_id);

            DB::commit();
            return redirect($session->url);
        }
        catch(\Throwable $th){
            DB::rollback();
            $errorMessage = $th->getMessage();
            dd($errorMessage);
        }
            
        
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
    
    public function success(Request $request)
    {
        // echo 'ok';
        $products = session()->get('products');
        $products_quantites=json_decode($products); 
        $user_id = session()->get('user_id');
        $subtotal = session()->get('subtotal');
        
        $sessionId = $request->get('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
         
    
        try {
            $session = Session::retrieve($sessionId);


            if (!$session) {
                throw new NotFoundHttpException();
            }


            DB::beginTransaction();

            try {
                foreach ($products_quantites as $pro_qte) {
                    Order::create([
                        "product_id" => $pro_qte->id,
                        "user_id" => $user_id,
                        "qte" => $pro_qte->quantity,
                        "num_order" => $sessionId,
                    ]);
                    $product=Product::find($pro_qte->id);
                    $product->qte_order+=$pro_qte->quantity;
                    $product->save();
                }
                $payment = Payment::create([
                    'num_order' => $session->id,
                    'amount' => $subtotal,
                    'currency' => $session->currency,
                    'payment_status' => $session->status,
                    'payment_method' => $session->payment_method_types[0],
                    'user_id' => $user_id,
                ]);
                Cart::where('user_id',$user_id)->delete();
                
                $mail=$this->mailer();
                $user=User::find($user_id);
                $mail->addAddress($user->email,$user->name);
                $mail->Subject = "Invoice Receipt Confirmation for Your Recent Payment (SuperNova)";
                $mail->Body = '<html> <head></head>
                    <body>
                    <p>We are pleased to inform you that the Payment ('.$subtotal.') has successfully received. This email serves as a confirmation for the same. We appreciate your timely action and thank you for choosing our services. Please retain this email as a reference for future purposes.</p>
                    <p>Best wishes</p>
                    </body>
                    </html>';

                $mail->send();
                    
                DB::commit();
                return redirect()->route('home')->with("success", 'Payment & Reservation Successfully');
                
            } catch (\Throwable $th) {
                DB::rollback();
                $errorMessage = $th->getMessage();
                dd($errorMessage);
            }

        } catch (Exception $e) {
            throw new NotFoundHttpException();
        }

        // send ticket here 
    }
    public function get_payments($id){
        $payments=Payment::where('user_id',$id)->get();
        if(count($payments)>0){
            return response()->json([
                'exist' => true,
                'payments' => $payments
            ]);
        }
        else{
            return response()->json([
                'exist' => false,
                'message' => 'Payments not found',
            ]);
        }
    }
    public function get_orders($num_order){
        $orders=Order::where('num_order',$num_order)->with('product.sub_category.category')->get();
        if(count($orders)>0){
            return response()->json([
                'exist' => true,
                'orders' => $orders
            ]);
        }
        else{
            return response()->json([
                'exist' => false,
                'message' => 'Payments not found',
            ]);
        }
    }
    public function getAll_payments(){
        $payments=Payment::with('user')->orderBy('id','desc')->paginate(10);
        if(count($payments)>0){
            return response()->json([
                'exist' => true,
                'payments' => $payments
            ]);
        }
        else{
            return response()->json([
                'exist' => false,
                'message' => 'Payments not found',
            ]);
        }
    }


}
