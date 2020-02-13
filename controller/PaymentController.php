<?php

class PaymentController{
    function __construct($action)
    {
        try{
            switch($action){
                case 'payment_endpoint':
                    $token = $_REQUEST['token'];
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::EndPayment($token, $order_id);
                    break;

                case 'payment_notification':
                    $token = $_REQUEST['token'];
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::Notification($token, $order_id);
                    break;

                case 'payment_cancel':
                    $order_id = $_REQUEST['order_id'];
                    PaymentModel::Cancel($order_id);
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