<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 22:17
 * 
 * Here you can set admins actions and connected user actions
 */

//Current folder
$rep=__DIR__.'/../';
$view_rep = "$rep/view";

//Database
$base="db734087973";
$dblogin="dbo734087973";
$dbpassword="Acty-63300";
$dsn = "mysql:host=db734087973.db.1and1.com;dbname=db734087973";

//Admins actions
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
    'admin_delete_review',
    'newsletter_form',
    'send_newsletter'
);

//Connected users actions
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

$payment_actions = array(
    'payment_notification',
    'payment_cancel',
    'payment_endpoint'
);

$mail_actions = array(
    'mail_show',
    'mail_send'
);

// connection settings
DEFINE('MERCHANT_ID', '55014688529519');
DEFINE('ACCESS_KEY', 'c9NO9GpRWqosIUhpM76A');
DEFINE('ACCESS_KEY_REF', '');
DEFINE('PROXY_HOST', '');
DEFINE('PROXY_PORT', '');
DEFINE('PROXY_LOGIN', '');
DEFINE('PROXY_PASSWORD', '');
DEFINE('ENVIRONMENT', 'PROD');

// CONSTANT
DEFINE('STATUS_WAITING_FOR_PAYMENT', 0);
DEFINE('STATUS_PAYMENT_BEING_PROCESSED', -2);
DEFINE('STATUS_ORDER_BEING_PROCESSED', 1);
DEFINE('STATUS_IN_DELIVERING', 2);
DEFINE('STATUS_DELIVERED', 3);
DEFINE('STATUS_CANCEL', -1);
DEFINE('STATUS_PAYMENT_DECLINED', -3);
