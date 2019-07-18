<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:17
 */

//Repertoire courant
$rep=__DIR__.'/../';
$view_rep = "$rep/view";

//Base de données
$base="db734087973";
$dblogin="dbo734087973";
$dbpassword="Acty-63300";
$dsn = "mysql:host=db734087973.db.1and1.com;dbname=db734087973";

$actions_admin = array(
    'dashboard',
    'dashboard4',
    'load_page_dashboard',
    'add_category_page',
    'add_category',
    'edit_category_page',
    'edit_category',
    'delete_category',
    'add_product_page',
    'add_product',
    'edit_product_page',
    'edit_product',
    'clone_product',
    'copy_product',
    'move_product',
    'add_thumbnail',
    'delete_thumbnail',
    'delete_product',
    'add_voucher_page',
    'add_voucher',
    'delete_voucher',
    'change_status_order',
    'user_page',
    'add_highlight_product',
    'remove_highlight_product',
    'testmail',
    'load_tests',
    'dashboard_load_tab',
    'admin_delete_review'
);
$actions_connected = array(
    'load_page_connected',
    'logout',
    'change_informations',
    'change_password',
    'delete_review',
    'invert_newsletter',
    'show_bill',
    'delete_address',
    'init_birthlist',
    'creation_birthlist',
    'add_selected_items_birthlist',
    'delete_product_birthlist',
    'back_to_step_2',
    'back_temporary_to_step_2',
    'load_birthlist_billing',
    'load_birthlist_payment',
    'init_birthlist_payment',
    'birthlist_order_cancel',
    'add_product_to_wishlist',
    'delete_item_from_wishlist'
);