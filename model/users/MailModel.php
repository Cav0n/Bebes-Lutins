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
    }

    public static function send_order_mail_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/order-confirmation.php')));

        self::send_mail($order->getCustomer()->getMail(), "Votre commande ". $order_id, $message);
    }

    public static function send_payment_fail_mail_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/payment-declined.php')));
        $message = (str_replace('$$$customer', $order->getCustomer()->getFirstname() . " " . $order->getCustomer()->getSurname(), $message));
        self::send_mail($order->getCustomer()->getMail(), "Problème avec votre commande " . $order_id, $message);
    }

    public static function send_order_cancel_for(Order $order)
    {
        $message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/order-cancel.php')));
        $message = (str_replace('$$$date', $order->getDateString() . ' à ' . $order->getDateHoursString(), $message));

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

    public static function send_newsletter(string $title, string $text, $image_name = null, bool $has_button, $button_title = null, $button_link = null){
        echo "Envoi en cours<BR>";
        $message = file_get_contents('view/html/mail/newsletter-template.php');

        $message = (str_replace('$$$title', $title, $message));
        $message = (str_replace('$$$text', $text, $message));
        $message = (str_replace('$$$image', self::create_image($image_name), $message));
        if($has_button){ 
            $message = (str_replace('$$$button', self::create_button($button_title, $button_link), $message)); 
        } else $message = (str_replace('$$$button', '', $message));

        self::send_mail('cav0n@hotmail.fr', 'Newsletter Bébés Lutins', $message);
        echo 'Newsletter envoyé à cav0n@hotmail.fr 🤟🏻<BR>';
    }

    private static function create_image($image){
        if($image != null){
            return "
            <tr>
                <td align='center' class='section-img'>
                    <img src='https://www.bebes-lutins.fr/view/assets/images/utils/newsletters/$image' style='display: block; width: 590px;' width='590' border='0' alt='' />
                </td>
            </tr>"; 
        } else return '';
    }

    private static function create_button($button_title, $button_link){
        return "
        <tr>
            <td align='center'>
                <table border='0' align='center' width='200' cellpadding='0' cellspacing='0' bgcolor='5bd383' style=''>

                    <tr>
                        <td height='10' style='font-size: 10px; line-height: 10px;'>&nbsp;</td>
                    </tr>

                    <tr>
                        <td align='center' style='color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 26px;'>


                            <div style='line-height: 26px;'>
                                <a href='https://$button_link' style='color: #ffffff; text-decoration: none;'>$button_title</a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height='10' style='font-size: 10px; line-height: 10px;'>&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>";
    }
}