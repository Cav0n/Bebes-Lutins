<?php

use \PHPMailer\PHPMailer\PHPMailer;

class MailModel
{
    private static function send_mail($recipient, $subject, $text){
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

    private static function send_mail_for_administration($from, $name,$subject, $text){
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
            $mail->setFrom("$from", "$name");
            $mail->addAddress("contact@bebes-lutins.fr");

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

    public static function send_mail_personnalized($recipient, $subject, $title, $text){
        $message = file_get_contents('view/html/mail/template.php');

        $message = (str_replace('$$$title', $title, $message));
        $message = (str_replace('$$$text', $text, $message));
        self::send_mail($recipient, $subject, $message);
    } 

    public static function send_mail_personnalized_for_administration($from, $name, $subject, $title, $text){
        $message = file_get_contents('view/html/mail/template.php');

        $message = (str_replace('$$$title', $title, $message));
        $message = (str_replace('$$$text', $text, $message));
        self::send_mail_for_administration($from, $name, $subject, $message);
    } 

    public static function send_order_notification_for_administration(Order $order){
        $admin_message = file_get_contents('view/html/mail/notification-administration.php');

        $admin_message = (str_replace('$$$title', "Une commande a été effectuée 😎", $admin_message));

        $admin_message = (str_replace('$$$text', 
            $order->getCustomer()->getFirstname() . ' ' . $order->getCustomer()->getSurname() . ' a passé une commande sur le site d\'une valeur de ' . UtilsModel::FloatToPrice($order->getPriceAfterDiscount()) . '.',
            $admin_message));

        $admin_message = (str_replace('$$$button', 
            self::create_button('Voir la facture', 'www.bebes-lutins.fr/dashboard/facture-' . $order->getId()),
            $admin_message));

        self::send_mail('contact@bebes-lutins.fr', 'Nouvelle commande !', $admin_message);
    }

    public static function send_order_mail_for(Order $order)
    {
        /**
         * Mail for customer
         */
        $customer_message = (str_replace('$$$order_id', $order->getID(), file_get_contents('view/html/mail/order-confirmation.php')));
        self::send_mail($order->getCustomer()->getMail(), "Votre commande ". $order_id, $customer_message);

        self::send_order_notification_for_administration($order);
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
        self::send_order_notification_for_administration($order);
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

    public static function send_newsletter(string $title, string $text, $image_name = null, bool $has_button, $button_title = null, $button_link = null, string $customer_mail = null){
        echo "Envoi en cours<BR>";
        $message = file_get_contents('view/html/mail/newsletter-template.php');

        $message = (str_replace('$$$title', $title, $message));
        $message = (str_replace('$$$text', $text, $message));
        $message = (str_replace('$$$unsubscribe_link', self::create_unsubscribe_link($customer_mail), $message));
        $message = (str_replace('$$$image', self::create_image($image_name), $message));
        if($has_button){ 
            $message = (str_replace('$$$button', self::create_button($button_title, $button_link), $message)); 
        } else $message = (str_replace('$$$button', '', $message));

        self::send_mail($customer_mail, 'Newsletter Bébés Lutins', $message);
        echo "Newsletter envoyé à $customer_mail 🤟🏻<BR>";
    }

    public static function newsletter_unsubscribe(string $mail){
        try{
        UserGateway::UnsubscribeMailFromNewsletter($mail);
        } catch(Exception $e){echo $e;}
        $mail = strtolower($mail);

        echo "Votre adresse <b>$mail</b> a bien été désincrite de notre newsletter. <BR>
        Vous pouvez toutefois vous inscrire de nouveau dans votre espace client.<BR>
        <BR>
        <a href='https://www.bebes-lutins.fr>Retour sur le site</a>";
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
                <table border='0' align='center' width='200' cellpadding='0' cellspacing='0' style='background-color:#5bd383;'>

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

    private static function create_unsubscribe_link($customer_mail){
        if($customer_mail != null){
            return "
            <table border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;' class='container590'>
                <tr>
                    <td align='left' style='color: #aaaaaa; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;'>
                        <div style='line-height: 24px;'>

                            <span><a style='font-size:0.85rem;' href='https://www.bebes-lutins.fr/description-newsletter/$customer_mail'>Se désinscrire</a></span>

                        </div>
                    </td>
                </tr>
            </table>";
        } else return "";
    }
}