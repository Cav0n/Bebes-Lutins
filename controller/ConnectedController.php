<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 19:49
 */

class ConnectedController
{

    /**
     * ConnectedController constructor.
     */
    public function __construct(String $action)
    {
        if(isset($_SESSION['connected_user'])){ //Verify if the user is connected
            try{
                switch ($action){
                    case 'add_product_to_wishlist':
                        ConnectedModel::add_product_to_wishlist($_REQUEST['wishlist_id'], $_REQUEST['product_id']);
                        break;

                    case 'delete_item_from_wishlist':
                        ConnectedModel::delete_item_from_wishlist($_REQUEST['item_id']);
                        break;

                    case "load_page_connected":
                        ConnectedModel::load_page($_REQUEST['page']);
                        break;

                    case "logout":
                        ConnectedModel::logout();
                        break;

                    case "change_informations":
                        ConnectedModel::change_informations($_POST['id'], $_POST['surname'], $_POST['firstname'], $_POST['phone'], $_POST['mail']);
                        break;

                    case "invert_newsletter":
                        ConnectedModel::invert_newsletter($_REQUEST['user_id']);
                        break;

                    case "change_password":
                        ConnectedModel::change_password($_POST['id'], $_POST['old_password'], $_POST['new_password']);
                        break;

                    case "delete_review":
                        ConnectedModel::delete_review($_POST['review_id']);
                        break;

                    case "show_bill":
                        UtilsModel::load_page('show_bill');
                        break;

                    case "delete_address":
                        ConnectedModel::delete_address_complex($_POST['user_id'], $_POST['address_id']);
                        break;

                    case "init_birthlist":
                        ConnectedModel::init_birthlist($_POST['user_id']);
                        break;

                    case "creation_birthlist":
                        ConnectedModel::creation_birthlist($_POST['birthlist_id'], $_POST['mother_name'], $_POST['father_name'], $_POST['message']);
                        break;

                    case "add_selected_items_birthlist":
                        ConnectedModel::add_selected_items_birthlist($_POST['birthlist_id'], $_POST['products']);
                        break;

                    case "delete_product_birthlist":
                        ConnectedModel::delete_product_birthlist($_POST['birthlist_id'], $_POST['products']);
                        break;

                    case "back_to_step_2":
                        ConnectedModel::back_to_step_2($_GET['birthlist_id']);
                        break;

                    case "back_temporary_to_step_2":
                        ConnectedModel::back_temporary_to_step_2($_GET['birthlist_id']);
                        break;

                    case "load_birthlist_billing":
                        ConnectedModel::load_birthlist_billing($_GET['birthlist_id'], $_POST['items_id'], $_POST['quantities']);
                        break;

                    case "load_birthlist_payment":
                        ConnectedModel::load_birthlist_payment($_GET['birthlist_id'], $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'],$_POST['street_billing'],$_POST['city_billing'],$_POST['zip_code_billing'],$_POST['complement_billing'],$_POST['company_billing']);
                        break;

                    case "init_birthlist_payment":
                        ConnectedModel::init_birthlist_payment($_GET['birthlist_id'], $_POST['payment_method']);
                        break;

                    case "load_thanks_birthlist":
                        ConnectedModel::load_thanks_birthlist($_GET['birthlist_id']);
                        break;

                    case "birthlist_order_cancel":
                        ConnectedModel::cancel_birthlist_order($_GET['order_id'], $_GET['birthlist_id']);
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
        } else {
            $_SESSION['error-message'] = "Vous devez être connecté pour accéder à cela.";
            UtilsModel::load_page('error');
        }
    }
}