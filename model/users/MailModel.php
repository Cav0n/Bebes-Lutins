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

    public static function send_order_mail_to($recipient, $order_id)
    {
        $message = (str_replace('$$$order_id', $order_id, file_get_contents('view/html/mail/order-confirmation.php')));

        self::send_mail($recipient, "Votre commande ". $order_id, $message);
    }

    public static function send_payment_fail_mail_to($recipient, $order_id)
    {
        
    }
}