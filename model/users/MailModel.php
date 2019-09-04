<?php

use \PHPMailer\PHPMailer\PHPMailer;

class MailModel
{
    public static function send_mail($recipient, $subject, $text){
        require 'vendor/autoload.php';
        $order_id = 'FLOBER1312105003-5d6e788065d19';

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
            $mail->Body = (str_replace('$$$order_id', $order_id, file_get_contents('view/html/mail/template.php')));

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
}