<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 18:52
 * 
 * This controller get all request and give them to the right controller.
 */

class FrontController
{
    /**
     * FrontController constructor.
     */
    function __construct()
    {
        global $actions_admin, $actions_connected, $payment_actions;
        session_start();
        setlocale(LC_MONETARY, 'fr_FR');

        if(isset($_REQUEST['action'])) //The action is get here (in GET or POST)
            $action = $_REQUEST['action'];
        else
            $action = null;

        if(!isset($_SESSION['shopping_cart'])){
            $_SESSION['shopping_cart'] = serialize(new ShoppingCart("local", 0, array()));
        }

        try{
            if(in_array($action, $actions_admin)){ //If the action requested is an administrator action
                new AdminController($action); //Give the request to the AdminController
            }
            elseif (in_array($action, $actions_connected)){ //If the action requested is a connected user action
                new ConnectedController($action); //Give the request to the ConnectedController
            }
            elseif(in_array($action, $payment_actions)){ //If the action is a payment action
                new PaymentController($action);
            }
            else new VisitorController($action); //If it's another action then give it to the VisitorController
        } catch(PDOException $e){
            $_SESSION['error-message'] = "Erreur de base données : <p style='red'>$e</p>";
            UtilsModel::load_page("error");
        } catch (Exception $e){
            $_SESSION['error-message'] = "Erreur de développement : <p style='red;'>$e</p>";
            UtilsModel::load_page("error");
        }
    }
}