<?php

use \PHPMailer\PHPMailer\PHPMailer;

class MailModel
{
    public static function send_mail($recipient, $subject, $text){
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);
        try{
            $mail->CharSet = 'UTF-8';

            // SET SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = 0;

            // SET SERVER
            $mail->Host = "smtp.1and1.com";
            $mail->Port = 25;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Username = 'no-reply@bebes-lutins.fr';
            $mail->Password = 'Acty-63300';

            // SET RECIPIENTS
            $mail->setFrom('no-reply@bebes-lutins.fr', 'Bébés Lutins');
            $mail->addAddress("$recipient");

            // SET MESSAGE
            $mail->isHTML(true);
            $mail->Subject = "$subject";
            $mail->Body = $text;

            $mail->send();
        } catch (Exception $e){
            echo $e->getMessage();
            return "Une erreur s'est produite, veuillez vérifier votre adresse mail.";
        } catch (\PHPMailer\PHPMailer\Exception $e){
            echo $e->getMessage();
            return "Une erreur s'est produite, veuillez vérifier votre adresse mail.";
        }
        return;
    }

    public static function send_order_mail_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/order-confirmation.php')));

        self::send_mail($order->getCustomer()->getMail(), "Votre commande ". $order_id, $message);
    }

    public static function send_payment_fail_mail_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/payment-declined.php')));

        self::send_mail($order->getCustomer()->getMail(), "Problème avec votre commande " . $order_id, $message);
    }

    public static function send_order_cancel_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/order-cancel.php')));
        $message = (str_replace('$$$date', $order->getDateString() . ' à ' . $order->getDateHoursString, $message));

        self::send_mail($order->getCustomer()->getMail(), "Commande annulée", $message);
    }

    public static function send_order_update_for(Order $order)
    {
        $message = file_get_contents('view/html/mail/order-update.php');
        $message = (str_replace('$$$customer', ucfirst($order->getCustomer()->getFirstname()) . " " . ucfirst($order->getCustomer()->getSurname()), $message));
        $message = (str_replace('$$$order_id', $order->getID(), $message));
        $message = (str_replace('$$$order_s_friendly', $order->getFriendlyStatus(), $message));
        $message = (str_replace('$$$order_status', $order->statusToString(), $message));
        $message = (str_replace('$$$order_s_description', $order->getStatusDescription(), $message));
        $message = (str_replace('$$$image', $order->getStatusImage(), $message));

        self::send_mail($order->getCustomer()->getMail(), "Votre commande " . $order->getID() . " est ". $order->statusToString(), $message);
    }
}