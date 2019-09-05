<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 19:49
 */

class AdminController
{

    /**
     * AdminController constructor.
     */
    public function __construct(String $action)
    {
        if(isset($_SESSION['connected_user'])){
            $usercontainer = new UserContainer(unserialize($_SESSION['connected_user'])); //Get the user
            $user = $usercontainer->getUser(); //Containers is used for autocompletion with PHPStorm
            if($user->getPrivilege()) { //If the user has privilege more than 0 he is an administrator
                switch ($action) {
                    case "load_tests":
                        AdminModel::load_page($_GET['test']);
                        break;

                    case "dashboard":
                        AdminModel::load_page("dashboard");
                        break;

                    case "dashboard4":
                        AdminModel::load_page("dashboard4");
                        break;

                    case "load_page_dashboard":
                        AdminModel::load_page_dashboard($_REQUEST['section'], $_REQUEST['page'], $_REQUEST['option']);
                        break;

                    case "dashboard_load_tab":
                        AdminModel::load_dashboard_tab($_GET['header_tab'], $_GET['option']);
                        break;

                    case "add_category_page":
                        AdminModel::load_page('add_category');
                        break;

                    case "add_category":
                        AdminModel::add_category( $_POST['nom'], $_POST['parent'], $_POST['description']);
                        break;

                    case "edit_category_page":
                        AdminModel::load_page('edit_category');
                        break;

                    case "edit_category":
                        AdminModel::edit_category($_POST['name'], $_POST['old_image_name'],  $_POST['description'], $_POST['old_name'], $_POST['rank']);
                        break;

                    case "delete_category":
                        AdminModel::delete_category($_REQUEST['category_name']);
                        break;

                    case "add_product_page":
                        AdminModel::load_page('add_product');
                        break;

                    case "add_product":
                        AdminModel::add_product($_POST['name'], $_POST['price'], $_POST['stock'], $_POST['description_big'], $_POST['description_small'], $_POST['category'], $_POST['custom_id']);
                        break;

                    case "add_highlight_product":
                        AdminModel::add_highlight_product($_POST['product_id']);
                        break;

                    case "remove_highlight_product":
                        AdminModel::remove_highliht_product($_POST['product_id']);
                        break;

                    case "edit_product_page":
                        AdminModel::load_page('edit_product');
                        break;

                    case "edit_product":
                        AdminModel::edit_product($_POST['id_copy'],$_POST['id'], $_POST['name'], $_POST['price'], $_POST['stock'], $_POST['description_big'], $_POST['description_small'], $_POST['old_image_name'], $_POST['custom_id']);
                        break;

                    case "clone_product":
                        AdminModel::clone_product($_POST['clone_category'], $_POST['product_id_copy']);
                        break;

                    case "copy_product":
                        AdminModel::copy_product($_POST['clone_category'], $_POST['product_id']);
                        break;

                    case "move_product":
                        AdminModel::move_product($_POST['clone_category'], $_POST['product_id']);
                        break;

                    case "add_thumbnail":
                        AdminModel::add_thumbnail($_POST['product_id']);
                        break;

                    case "delete_thumbnail":
                        AdminModel::delete_thumbnail($_POST['thumbnail_name'], $_POST['product_id']);
                        break;

                    case "delete_product":
                        AdminModel::delete_product($_POST['id_product']);
                        break;

                    case "add_voucher_page":
                        AdminModel::add_voucher_page();
                        break;

                    case "add_voucher":
                        AdminModel::add_voucher($_POST['name'], $_POST['discount'], $_POST['type'], $_POST['date_beginning'], $_POST['date_end'], $_POST['number_of_usage'], $_POST['time_end'], $_POST['number_per_user'], $_POST['minimal_purchase'], $_POST['deleted']);
                        break;

                    case "delete_voucher":
                        AdminModel::delete_voucher($_POST['voucher_id']);
                        break;

                    case "change_status_order":
                        AdminModel::change_status_order($_POST['order_id'], $_POST['new-status'], $_POST['admin_message']);
                        break;

                    case "user_page":
                        AdminModel::load_page('user_page');
                        break;

                    case "testmail":
                        AdminModel::testmail();
                        break;

                    case "admin_delete_review":
                        AdminModel::delete_review($_GET['id']);
                        break;

                    case "send_newsletter":
                        AdminModel::send_newsletter($_REQUEST['title'], $_REQUEST['text'], $_REQUEST['image_name'], $_REQUEST['has-button'], $_REQUEST['button-title'], $_REQUEST['button-link']);
                        break;

                    default :
                        UtilsModel::load_page('error');
                        break;
                }
            }
        }
        else {
            $_SESSION['error-message'] = "Vous n'avez pas le droit d'accéder à cela.";
            UtilsModel::load_page('error');
        }
    }
}