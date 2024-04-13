<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentController extends Controller
{

    public function createSession(Request $request)
    {
        DB::beginTransaction();
        try{
            $order_total=$request->subtotal;
            $order_total_number = number_format($order_total, 2);
            $decimal_num_dec = str_replace(',', '', $order_total_number);

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => "Test Payment",
                    ],
                    'unit_amount' => $decimal_num_dec,
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

    public function success(Request $request)
    {
        // echo 'ok';
        $products = session()->get('products');
        $user_id = session()->get('user_id');
        $subtotal = session()->get('subtotal');
        
        $sessionId = $request->get('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        dd($user_id);
        dd($products);

        // try {
        //     $session = Session::retrieve($sessionId);


        //     if (!$session) {
        //         throw new NotFoundHttpException();
        //     }


        //     DB::beginTransaction();

        //     try {

        //         $order = Order::create([
        //             'product_id' => $session->id,
        //             'user_id' => $session->amount_total,
        //             'qte' => $session->currency,
        //             'num_order' => $session->status,
        //         ]);

        //         $payment = Payment::create([
        //             'num_order' => $session->id,
        //             'amount' => $session->amount_total,
        //             'currency' => $session->currency,
        //             'payment_status' => $session->status,
        //             'payment_method' => $session->payment_method_types[0],
        //             'user_id' => $user_id,
        //         ]);

                
        //         DB::commit();
        //         return redirect()->route('home')->with("success", 'Payment & Reservation Successfully');
                
        //     } catch (\Throwable $th) {
        //         DB::rollback();
        //         $errorMessage = $th->getMessage();
        //         dd($errorMessage);
        //     }

        // } catch (Exception $e) {
        //     throw new NotFoundHttpException();
        // }

        // send ticket here 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
