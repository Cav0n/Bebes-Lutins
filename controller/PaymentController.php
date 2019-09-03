<?php

class PaymentController{
    function __construct($action)
    {
        try{
            switch($action){
                case 'payment_verification':
                    $token = $_REQUEST['token'];
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::verification($token, $order_id);
                    break;

                case 'payment_notification':
                    $token = $_REQUEST['token'];
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::notification($token, $order_id);
                    break;

                case 'payment_cancel':
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::cancel($order_id);
                    break;

                default:
                    echo 'Une erreur s\'est produite, veuillez réessayer.';
                    break;
            }
        } catch(Exception $e) {
            echo $e;
        }
    }
}