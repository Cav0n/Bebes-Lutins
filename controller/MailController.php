<?php 

class MailController
{
    function __construct($action)
    {
        global $view_rep;
        try{
            switch($action){
                case 'mail_send':
                    MailModel::send_mail('cav0n@hotmail.fr', 'Merci pour votre commande', 'Votre commande a été effectué avec succés. Nous la traitons aussi rapidement que possible');
                    break;

                case 'mail_order_send':
                    break;

                case 'mail_show':
                    require("$view_rep/html/mail/template.php");
                    break;

                default:
                    break;
            }
        } catch(Exception $e){
            echo 'Erreur : '. $e;
        }
    }
}