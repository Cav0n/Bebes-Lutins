<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\ShoppingCart;

class PaymentController extends Controller
{
    public function endPoint(Request $request, Order $order)
    {
        //TODO : VERIFICATION SUPPLEMENTAIRE TOKEN + ORDER_ID
        $payment_details = self::verify($request, $order);

        if ($payment_details['is_payed']){
            $shopping_cart = session('shopping_cart');
            $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();

            $shopping_cart->isActive = 0;
            $shopping_cart->save();

            session(['shopping_cart' => null]);

            if($order->status < 1){
                $order->status = 1;
                $order->save();
                //TODO: SEND MAIL
            }

            return redirect('/merci');
        } else {  
            if($order->status > -3){
                $order->status = -3;
                $order->save();

                foreach($order->order_items as $item){
                    $item->product->stock = $item->product->stock + $item->quantity;
                    $item->product->save();
                }
                //TODO: SEND MAIL
            }

            return redirect('/paiement-annule');
        }
    }

    public function cancel(Request $request, Order $order)
    {
        $token = $request['token'];

        if($order->status > -3){
            foreach($order->order_items as $item){
                $item->product->stock = $item->product->stock + $item->quantity;
                $item->product->save();
            }

            $order->status = -3;
            $order->save();
            //TODO: SEND MAIL
        }

        

        return redirect('/paiement-annule');
    }

    public function notification(Request $request, Order $order)
    {
        $payment_details = self::verify($request, $order);

        if($payment_details['is_payed']){
            if( $order->getStatus() < 1 ){
                $order->status = 1;
                $order->save();
                //TODO: SEND MAIL
            }
        } else {
            if($order->status != -3 && $order->status != -1){
                $order->status = -3;
                $order->save();
                //TODO: SEND MAIL
            }
        }

    }

    public function verify(Request $request, Order $order)
    {
        //return ['is_payed' => true, 'code' => 0, 'message' => "YES"]; //GLITCH

        $token = $request['token'];

        $paylineSDK = new \App\Payment\paylineSDK(env("MERCHANT_ID"), env("ACCESS_KEY"), env("PROXY_HOST"), env("PROXY_PORT"), env("PROXY_LOGIN"), env("PROXY_PASSWORD"), env("ENVIRONMENT"));
        $payment_details = $paylineSDK->getWebPaymentDetails(['token'=>$token]);
        
        $result_code = $payment_details['result']['code'];
        $result_longMessage = $payment_details['result']['longMessage'];

        switch($result_code){
            case '00000':
                return ['is_payed' => true, 'code' => $result_code, 'message' => $result_longMessage];
                break;

            case '01001':
                return ['is_payed' => true, 'code' => $result_code, 'message' => $result_longMessage];
                break;

            default:
                return ['is_payed' => false, 'code' => $result_code, 'message' => $result_longMessage];
                break;
        }
        return false;
    }
}
