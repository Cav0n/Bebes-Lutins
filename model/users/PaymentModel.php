<?php

class PaymentModel{
    public static function EndPayment($token, $order_id){
        if($order_id != null){
            /**
             * TODO : VERIFICATION SUPPLEMENTAIRE TOKEN + ORDER_ID
             */
            $payment_details = self::Verification($token);
            $order = OrderGateway::GetOrderFromDBByID2($order_id);

            if ($payment_details['is_payed']){
                $_POST['order_id'] = $order_id;

                if($order->getStatus() < STATUS_ORDER_BEING_PROCESSED){
                    OrderGateway::UpdateOrderStatusWithOrderID($order_id, STATUS_ORDER_BEING_PROCESSED);
                    MailModel::send_order_mail_to($order->getCustomer()->getMail());
                }
                ?>
                <script type="text/javascript">
                    document.location.href="https://www.bebes-lutins.fr/merci/<?php echo $order->getID(); ?>";
                </script>
                <?php
            } else {  
                if($order->getStatus() > STATUS_PAYMENT_DECLINED){
                    OrderGateway::UpdateOrderStatusWithOrderID($order_id, STATUS_PAYMENT_DECLINED);
                    /**
                     * TODO : MAIL CONTROLLER
                     */
                }

                ?>
                <script type="text/javascript">
                    document.location.href="https://www.bebes-lutins.fr/erreur-paiement";
                </script>
                <?php
            }
        } else {
            http_response_code(404);
            echo '<BR>Nous ne connaissons pas l\'identifiant de votre commande.';
        }
    }

    public static function Notification($token, $order_id){
        if($order_id != null){
            http_response_code(200);
            $payment_details = self::Verification($token);
            $order = OrderGateway::GetOrderFromDBByID2($order_id);

            if($payment_details['is_payed']){
                if($payment_details['code'] == '00000') {
                    if( $order->getStatus() < STATUS_ORDER_BEING_PROCESSED){
                        OrderGateway::UpdateOrderStatusWithOrderID($order_id, STATUS_ORDER_BEING_PROCESSED);
                        /**
                         * TODO : MAIL CONTROLLER
                         */
                    }
                }
                if($payment_details['code'] == '01001') {
                    if($order->getStatus() < STATUS_PAYMENT_BEING_PROCESSED){
                        OrderGateway::UpdateOrderStatusWithOrderID($order_id, STATUS_PAYMENT_BEING_PROCESSED);
                        /**
                         * TODO : MAIL CONTROLLER
                         */
                    }
                }
            } else {
                if($order->getStatus() > STATUS_PAYMENT_DECLINED){
                    OrderGateway::UpdateOrderStatusWithOrderID($order_id, STATUS_PAYMENT_DECLINED);
                    /**
                     * TODO : MAIL CONTROLLER
                     */
                }
            }
        } else {
            http_response_code(404);
            echo '<BR>Nous ne connaissons pas l\'identifiant de votre commande.';
        }
    }

    public static function Verification($token){
        $paylineSDK = new paylineSDK(MERCHANT_ID, ACCESS_KEY, PROXY_HOST, PROXY_PORT, PROXY_LOGIN, PROXY_PASSWORD, ENVIRONMENT, null);
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

    public static function Cancel($order_id){
        if($order_id != null){
            unset($_SESSION['shopping_cart']);
            unset($_SESSION['order']);

            $order = OrderGateway::GetOrderFromDBByID2($order_id);

            if($order->getStatus() > STATUS_CANCEL){
                OrderGateway::UpdateOrderStatusWithOrderID($order->getId(), STATUS_CANCEL);
                /**
                 * TODO : MAIL CONTROLLER 
                 */
            } 

            ?>
            <script type="text/javascript">
                document.location.href="https://www.bebes-lutins.fr/paiement-annule";
            </script>
            <?php

        } else {
            http_response_code(404);
            echo '<BR>Nous ne connaissons pas l\'identifiant de votre commande.';
        }
    }
}