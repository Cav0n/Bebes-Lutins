<?php

namespace App;

class OrderStatus
{
    public static function statusToString(int $status){
        switch($status){
            case 0:
                return 'en attente de paiement';
                break;
            case 1:
                return 'en cours de traitement';
                break;
            case 2:
                return 'en cours de livraison';
                break;
            case 22:
                return 'a retirer à l\'atelier';
                break;
            case 3:
                return 'livrée';
                break;
            case 33:
                return 'participation enregistrée';
                break;
            case -1:
                return 'annulée';
                break;
            case -2:
                return 'paiement en cours de traitement';
                break;
            case -3:
                return 'paiement refusée';
                break;

            default:
                return '[status inconnu]';
                break;  
        }  
    }

    public static function statusToRGBColor(int $status){
        switch($status){
            case 0:
                return 'rgb(238, 221, 0)'; //YELLOW
                break;
            case 1:
                return 'rgb(0,0,0)'; //BLACK
                break;
            case 2:
                return 'rgb(67, 86, 214)'; //BLUE
                break;
            case 22:
                return 'rgb(67, 86, 214)'; //BLUE
                break;
            case 3:
                return 'rgb(67, 204, 90)'; //GREEN
                break;
            case 33:
                return 'rgb(67, 204, 90)'; //GREEN
                break;
            case -1:
                return 'rgb(204, 52, 44)'; //RED
                break;
            case -2:
                return 'rgb(238, 221, 0)'; //YELLOW
                break;
            case -3:
                return 'rgb(204, 52, 44)'; //RED
                break;

            default:
                return 'rgb(0,0,0)'; //BLACK
                break;  
        }  
    }

    /**
     * Create title and message for order's status change notification
     *
     * @param  \App\Order Order to get the status and the user from
     * @return array Response with the title and the message;
     */
    public static function statusToEmailMessage(Order $order) : array{
        $status = $order->status;
        $firstname_lastname = $order->user->firstname . ' ' .$order->user->lastname;
        $order_id = $order->id;
        $order_date = $order->created_at->formatLocalized("%A %e %B %Y");
        $result = array();
        switch($status){
            case 0:
                $title = 'Votre commande a été enregistrée';
                $message = "
                Bonjour $firstname_lastname,<BR>
                Nous avons enregistrée votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date
                Nous préparerons votre commande dans les plus brefs délais.";
                break;
            case 1:
                $title = 'Nous préparons votre commande';
                $message = "
                Bonjour $firstname_lastname,<BR>
                Nous avons bien reçu le paiement de votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date.
                Nous préparons à présent votre colis, il devrait être expédié d'ici demain.";
                break;
            case 2:
                $title = 'Votre commande a été expédié';
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date vient de quitter notre atelier et devrait arriver 
                chez vous dans 2 jours ouvrables maximum.";
                break;
            case 22:
                $title = "Votre commande est prête à l'atelier";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date est prête à être retiré à notre atelier.<BR>
                Nous sommes ouverts de 9h00 à 12h00 et de 13h30 à 16h00 du lundi au vendredi.<BR>
                <BR>
                Pour rappel, voici l'adresse de Bébés Lutins : <BR>
                ACTYPOLES (Bébés Lutins)<BR>
                Rue du 19 Mars 1962<BR>
                63300 THIERS<BR>";
                break;
            case 3:
                $title = "Votre commande est terminée";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date vous a été livré, elle est donc terminée.<BR>
                Nous espérons que celle-ci vous donnera entière satisfaction. Si vous avez besoin
                de renseignements vous pouvez nous contacter à l'adresse : <a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a>.";
                break;
            case 33:
                $title = "Votre participation a été enregistrée";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre participation <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date a bien été enregistrée.<BR>";
                break;
            case -1:
                $title = "Votre commande a été annulée";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date a bien été annulée.<BR>
                Si vous avez déjà été débité vous serez remboursé dans les plus brefs délais.";
                break;
            case -2:
                $title = "Nous vérifions votre commande";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Le paiement de votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date est en train d'être vérifié.<BR>
                Nous commencerons la préparation de votre commande dès la validation de votre paiement.";
                break;
            case -3:
                $title = "Un problème est survenu lors du paiement de votre commande";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Nous sommes au regret de vous annoncer qu'une erreur est survenue lors du paiement de votre
                commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date.<BR>
                Nous vous invitons à repasser votre commande ou à nous contacter dès que possible.<BR>
                Vous pouvez nous contacter à l'adresse <a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a>.";
                break;

            default:
                $title = "Votre commande a changé d'état";
                $message = "
                Bonjour $firstname_lastname,<BR>
                Votre commande <a href='http://192.168.1.33/commandes/$order_id'>#$order_id</a> du $order_date a changé d'état. Il nous est malheureusement impossible de déterminer l'état
                actuel de votre commande. Veuillez nous contacter au plus vite avec votre numéro de commande 
                ($order_id) pour obtenir de l'aide.<BR>.
                Vous pouvez nous contacter à l'adresse <a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a>.";
                break;  
        }

        $result['title'] = $title;
        $result['message'] = $message;
        return $result;
    }
}
