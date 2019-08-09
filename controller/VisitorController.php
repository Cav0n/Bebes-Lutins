<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 19:49
 */

class VisitorController
{

    /**
     * VisitorController constructor.
     */
    public function __construct($action)
    {
        try{
            switch ($action){
                case null:
                    UtilsModel::load_page("accueil");
                    break;

                case "load_page":
                    UtilsModel::load_page($_REQUEST['page']);
                    break;

                case "load_static_page":
                    UtilsModel::load_static_page($_REQUEST['page']);
                    break;

                case "show_all_products":
                    UtilsModel::show_all_products();
                    break;

                case "show_less_products":
                    UtilsModel::show_less_products();
                    break;

                case "send_password_lost_link":
                    UtilsModel::send_password_lost_link($_POST['mail']);
                    break;

                case "reset_password":
                    UtilsModel::reset_password($_POST['mail'], $_POST['key'], $_POST['new_password']);
                    break;

                case "show_bill":
                    UtilsModel::load_page('show_bill');
                    break;

                case "send_message":
                    UtilsModel::send_message($_POST['name'], $_POST['mail'], $_POST['subject'], $_POST['message']);
                    break;

                case "shopping_cart_add_product":
                    if(isset($_SESSION['product']) && $_SESSION['product'] != null) $product = (new ProductContainer(unserialize($_SESSION['product'])))->getProduct();
                    else $product = ProductGateway::SearchProductByID2($_POST['product_id']);
                    UtilsModel::shopping_cart_add_product($product, $_POST['quantity']);
                    break;

                case "shopping_cart_add_voucher":
                    UtilsModel::shopping_cart_add_voucher($_POST['voucher']);
                    break;

                case "shopping_cart_add_message":
                    UtilsModel::shopping_cart_add_message($_POST['message']);
                    break;

                case "shopping_cart_delete_product":
                    UtilsModel::shopping_cart_delete_product($_POST['element_id']);
                    break;

                case "shopping_cart_change_quantity":
                    UtilsModel::shopping_cart_change_quantity($_POST['id'], $_POST['quantity']);
                    break;

                case "birthlist_item_change_quantity":
                    UtilsModel::birthlist_item_change_quantity($_POST['id'], $_POST['quantity']);
                    break;

                case "load_delivery":
                    UtilsModel::load_delivery();
                    break;

                case "load_payment":
                    UtilsModel::load_payment($_POST['address_type']);
                    break;

                case "init_pay":
                    UtilsModel::init_pay($_POST['payment_method']);
                    break;

                case "order_notification":
                    UtilsModel::OrderNotification($_GET['idcommande']);
                    break;

                case "notification_birthlist_order":
                    UtilsModel::OrderNotification($_GET['order_id']);
                    break;

                case "order_cancel":
                    UtilsModel::order_cancel($_REQUEST['idcommande']);
                    break;

                case "end_order_cheque":
                    UtilsModel::end_order_cheque();
                    break;

                case "registration":
                    VisitorModel::registration($_POST['surname'], $_POST['firstname'], $_POST['mail'], $_POST['phone'], $_POST['password'], $_POST['newsletter']);
                    break;

                case "activation":
                    VisitorModel::activation($_GET['user'], $_GET['key']);
                    break;

                case "login":
                    VisitorModel::login($_POST['mail'], $_POST['password']);
                    break;

                case "calculate_turnover":
                    UtilsModel::CalculateTurnover($_GET['beginning_date'], $_GET['end_date']);
                    break;

                case "add_review":
                    UtilsModel::add_review($_POST['product_id'], $_POST['customer_id'], $_POST['customer_name'], $_POST['rating'], $_POST['review-text']);
                    break;

                case "load_thanks":
                    UtilsModel::load_thanks();
                    break;

                case "thanks":
                    UtilsModel::load_page("thanks");
                    break;

                case "test":
                    UtilsModel::load_page("test");
                    break;

                case "test_mail":
                    UtilsModel::TestMail();
                    break;

                default:
                    UtilsModel::load_page(null);
                    break;
            }
        } catch(PDOException $e){
            $_SESSION['error-message'] = "Erreur de base données : <p style='red'>$e</p>";
            UtilsModel::load_page("error");
        } catch(Exception $e){
            $_SESSION['error-message'] = "Erreur de développement : <p style='red;'>$e</p>";
            UtilsModel::load_page("error");
        }
    }
}