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
}
