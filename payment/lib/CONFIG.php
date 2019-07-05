<?php
// connection settings
DEFINE('MERCHANT_ID', '55014688529519');
DEFINE('ACCESS_KEY', 'c9NO9GpRWqosIUhpM76A');
DEFINE('ACCESS_KEY_REF', '');
DEFINE('PROXY_HOST', '');
DEFINE('PROXY_PORT', '');
DEFINE('PROXY_LOGIN', '');
DEFINE('PROXY_PASSWORD', '');
DEFINE('ENVIRONMENT', 'PROD');

// web services settings
DEFINE( 'WS_VERSION', '');
DEFINE( 'PAYMENT_CURRENCY', '978');
DEFINE( 'ORDER_CURRENCY', '978');
DEFINE( 'SECURITY_MODE', '');
DEFINE( 'LANGUAGE_CODE', '');
DEFINE( 'PAYMENT_ACTION', '101');
DEFINE( 'PAYMENT_MODE', 'CPT');

DEFINE( 'CANCEL_URL', 'https://www.bebes-lutins.fr/?action=order_cancel&idcommande=');
DEFINE( 'NOTIFICATION_URL','https://www.bebes-lutins.fr/?action=order_notification');
DEFINE( 'RETURN_URL', 'https://www.bebes-lutins.fr/?action=load_thanks');

DEFINE( 'CANCEL_URL_BIRTHLIST', 'https://www.bebes-lutins.fr/?action=birthlist_order_cancel');
DEFINE( 'NOTIFICATION_URL_BIRTHLIST', 'https://www.bebes-lutins.fr/?action=notification_birthlist_order');
DEFINE( 'RETURN_URL_BIRTHLIST', 'https://www.bebes-lutins.fr/?action=load_page_connected&page=thanks_birthlist_payment');

DEFINE( 'CUSTOM_PAYMENT_TEMPLATE_URL', '');
DEFINE( 'CUSTOM_PAYMENT_PAGE_CODE', 'UVxJNmK2iRpbjPUgDoTj');
DEFINE( 'CONTRACT_NUMBER', '1104366');
DEFINE( 'CONTRACT_NUMBER_LIST', '');
DEFINE( 'SECOND_CONTRACT_NUMBER_LIST', '');

// demo settings
DEFINE( 'KIT_ROOT', 'http://localhost/KIT_PHP/PHP/');
?> 
