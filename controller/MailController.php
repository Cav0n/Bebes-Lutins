<?php 

class MailController
{
    function __construct($action)
    {
        global $view_rep;
        try{
            switch($action){
                case 'mail_send':
                    MailModel::send_mail('cav0n@hotmail.fr', 'Votre commande', file_get_contents('view/html/mail/payment-declined.php'));
                    break;

                case 'mail_show':
                    require("$view_rep/html/mail/order-update.php");
                    break;

                default:
                    break;
            }
        } catch(Exception $e){
            echo 'Erreur : '. $e;
        }
    }
}