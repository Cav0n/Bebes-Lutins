<?php

class PaymentModel{
    public static function verification($token, $order_id){
        $paylineSDK = new paylineSDK(MERCHANT_ID, ACCESS_KEY, PROXY_HOST, PROXY_PORT, PROXY_LOGIN, PROXY_PASSWORD, ENVIRONMENT, null);
        $payment_details = $paylineSDK->getWebPaymentDetails(['token'=>$token]);
        
        $result_code = $payment_details['result']['code'];
        $result_longMessage = $payment_details['result']['longMessage'];

        switch($result_code){
            case '00000':
                echo 'Paiement OK.';
                break;

            case '01001':
                echo 'Paiement OK mais vérification.';
                break;

            default:
                echo 'Problème avec le paiement. <BR>
                Code : ' . $result_code . '<BR>
                Message : '. $result_longMessage;
        }
    }

    public static function notification($token, $order_id){

    }

    public static function cancel($order_id){

    }
}