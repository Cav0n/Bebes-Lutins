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

                case 'send_newsletter_async':
                    MailModel::send_newsletter($_REQUEST['title'], $_REQUEST['text'], $_REQUEST['image_name'], $_REQUEST['has_button'], $_REQUEST['button_title'], $_REQUEST['button_link'], $_REQUEST['mail']);
                    break;

                case 'newsletter_unsubscribe':
                    MailModel::newsletter_unsubscribe($_REQUEST['mail']);
                    break;

                default:
                    break;
            }
        } catch(Exception $e){
            echo 'Erreur : '. $e;
        }
    }
}