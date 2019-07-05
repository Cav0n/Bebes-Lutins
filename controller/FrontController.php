<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 18:52
 */

class FrontController
{
    /**
     * FrontController constructor.
     */
    function __construct()
    {
        global $actions_admin, $actions_connected;
        session_start();
        setlocale(LC_MONETARY, 'fr_FR');

        if(isset($_REQUEST['action']))
            $action = $_REQUEST['action'];
        else
            $action = null;

        if(!isset($_SESSION['shopping_cart'])){
            $_SESSION['shopping_cart'] = serialize(new ShoppingCart("local", 0, array()));
        }

        try{
            if(in_array($action, $actions_admin)){
                new AdminController($action);
            }
            elseif (in_array($action, $actions_connected)){
                new ConnectedController($action);
            }
            else new VisitorController($action);
        } catch(PDOException $e){
            $_SESSION['error-message'] = "Erreur de base données : <p style='red'>$e</p>";
            UtilsModel::load_page("error");
        } catch (Exception $e){
            $_SESSION['error-message'] = "Erreur de développement : <p style='red;'>$e</p>";
            UtilsModel::load_page("error");
        }
    }
}