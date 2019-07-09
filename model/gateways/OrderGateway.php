<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:14
 */

class OrderGateway
{
    public static function GetOrdersFromGateway(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $users = array();
        $orders = array();
        $categories = array();

        $query = 'SELECT id, user_id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price,total_price, payment_method, voucher_id, birthlist_id, customer_message, admin_message FROM orders ORDER BY ordering_date DESC ;';
        $con->executeQuery($query);
        $orders_db = $con->getResults();

        $query = 'SELECT id, order_id, product_id, quantity, unit_price FROM order_item;';
        $con->executeQuery($query);
        $order_items_db = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product_backup ORDER BY name;";
        $con->executeQuery($query);
        $products_db = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user ORDER BY registration_date ASC;';
        $con->executeQuery($query);
        $users_db = $con->getResults();

        $query = 'SELECT id, mail, surname, firstname, phone, registration_date FROM user_no_account;';
        $con->executeQuery($query);
        $users_db_no_account = $con->getResults();

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup';
        $con->executeQuery($query);
        $address_list_db = $con->getResults();

        foreach ($users_db as $user_db){
            $users[] = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
        }

        foreach ($users_db_no_account as $user_no_account){
            $users[] = new UserConnected($user_no_account['id'], $user_no_account['surname'], $user_no_account['firstname'], $user_no_account['mail'], $user_no_account['phone'], 0, $user_no_account['registration_date'], false);

        }

        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $category, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
        }


        foreach ($orders_db as $order_db){
            foreach ($users as $user) {
                $user = (new UserContainer($user))->getUser();
                if ($user->getId() == $order_db['user_id']) {
                    $address_ok = 0;
                    foreach ($address_list_db as $address_db) {
                        if ($address_db['id'] == $order_db['shipping_address_id']) {
                            if($address_db['id'] == 'birthlist') $shipping_address = new Address('birthlist', $user, "none", "none", "none", "none", "none", 0, "none", "none");
                            else $shipping_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                            $address_ok++;
                        }
                        if ($address_db['id'] == $order_db['billing_address_id']) {
                            $billing_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                            $address_ok++;
                        }
                        if ($address_ok == 2) {
                            $order = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], null, $order_db['birthlist_id']);
                            if ($order_db['customer_message'] != null) $order->setCustomerMessage($order_db['customer_message']);
                            if ($order_db['admin_message'] != null) $order->setAdminMessage($order_db['admin_message']);
                            if ($order_db['new'] != null) $order->setNew($order_db['new']);
                            $orders[] = $order;
                            break;
                        }
                    }
                }
            }
        }

        foreach ($orders as $order) {
            foreach ($order_items_db as $order_item_db) {
                if ($order_item_db['order_id'] == $order->getID()) {
                    foreach ($products as $product) {
                        $product = (new ProductContainer($product))->getProduct();
                        if ($product->getId() == $order_item_db['product_id']) {
                            $order->addOrderItem(new OrderItem($order_item_db['id'], $product, $order_item_db['quantity'], $order_item_db['unit_price']));
                        }
                    }
                }
            }
        }

        return $orders;
    }

    public static function GetInPreparationOrderFromDB(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $users = array();
        $orders = array();
        $categories = array();

        $query = 'SELECT id, user_id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price,total_price, payment_method, voucher_id, birthlist_id, customer_message, admin_message FROM orders WHERE status < 2 AND status > -1 ORDER BY ordering_date DESC ;';
        $con->executeQuery($query);
        $orders_db = $con->getResults();

        $query = 'SELECT id, order_id, product_id, quantity, unit_price FROM order_item;';
        $con->executeQuery($query);
        $order_items_db = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product_backup ORDER BY name;";
        $con->executeQuery($query);
        $products_db = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user ORDER BY registration_date ASC;';
        $con->executeQuery($query);
        $users_db = $con->getResults();

        $query = 'SELECT id, mail, surname, firstname, phone, registration_date FROM user_no_account;';
        $con->executeQuery($query);
        $users_db_no_account = $con->getResults();

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup';
        $con->executeQuery($query);
        $address_list_db = $con->getResults();

        foreach ($users_db as $user_db){
            $users[] = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
        }

        foreach ($users_db_no_account as $user_no_account){
            $users[] = new UserConnected($user_no_account['id'], $user_no_account['surname'], $user_no_account['firstname'], $user_no_account['mail'], $user_no_account['phone'], 0, $user_no_account['registration_date'], false);

        }

        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $category, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
        }


        foreach ($orders_db as $order_db){
            foreach ($users as $user) {
                $user = (new UserContainer($user))->getUser();
                if ($user->getId() == $order_db['user_id']) {
                    $address_ok = 0;
                    foreach ($address_list_db as $address_db) {
                        if ($address_db['id'] == $order_db['shipping_address_id']) {
                            if($address_db['id'] == 'birthlist') $shipping_address = new Address('birthlist', $user, "none", "none", "none", "none", "none", 0, "none", "none");
                            else $shipping_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                            $address_ok++;
                        }
                        if ($address_db['id'] == $order_db['billing_address_id']) {
                            $billing_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                            $address_ok++;
                        }
                        if ($address_ok == 2) {
                            $order = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], null, $order_db['birthlist_id']);
                            if ($order_db['customer_message'] != null) $order->setCustomerMessage($order_db['customer_message']);
                            if ($order_db['admin_message'] != null) $order->setAdminMessage($order_db['admin_message']);
                            if ($order_db['new'] != null) $order->setNew($order_db['new']);
                            $orders[] = $order;
                            break;
                        }
                    }
                }
            }
        }

        foreach ($orders as $order) {
            foreach ($order_items_db as $order_item_db) {
                if ($order_item_db['order_id'] == $order->getID()) {
                    foreach ($products as $product) {
                        $product = (new ProductContainer($product))->getProduct();
                        if ($product->getId() == $order_item_db['product_id']) {
                            $order->addOrderItem(new OrderItem($order_item_db['id'], $product, $order_item_db['quantity'], $order_item_db['unit_price']));
                        }
                    }
                }
            }
        }

        return $orders;
    }

    public static function GetOrderFromDBByID(String $order_id) : Order{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, user_id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price,total_price, payment_method, voucher_id, birthlist_id, customer_message, admin_message, cancel FROM orders WHERE id=:order_id";
        $con->executeQuery($query, array(':order_id' => array($order_id, PDO::PARAM_STR)));
        $order_db = $con->getResults()[0];

        $query = 'SELECT id, order_id, product_id, quantity, unit_price FROM order_item WHERE order_id=:order_id;';
        $con->executeQuery($query, array(':order_id' => array($order_id, PDO::PARAM_STR)));
        $order_items_db = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();
        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product_backup ORDER BY name;";
        $con->executeQuery($query);
        $products_db = $con->getResults();
        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $category, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
        }

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($order_db['user_id'], PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];

        if($user_db == null){
            $query = 'SELECT id, mail, surname, firstname, phone, registration_date FROM user_no_account WHERE id=:user_id;';
            $con->executeQuery($query, array(':user_id' => array($order_db['user_id'], PDO::PARAM_STR)));
            $user_db = $con->getResults()[0];

            $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], 0, $user_db['registration_date'], true);

        } else $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:billing_address_id';
        $con->executeQuery($query, array(':billing_address_id' => array($order_db['billing_address_id'], PDO::PARAM_STR)));
        $billing_address_db = $con->getResults()[0];

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:shipping_address_id';
        $con->executeQuery($query, array(':shipping_address_id' => array($order_db['shipping_address_id'], PDO::PARAM_STR)));
        $shipping_address_db = $con->getResults()[0];

        $billing_address = new Address($billing_address_db['id'], $user, $billing_address_db['civility'], $billing_address_db['surname'], $billing_address_db['firstname'], $billing_address_db['street'], $billing_address_db['city'], $billing_address_db['postal_code'], $billing_address_db['complement'], $billing_address_db['company']);
        if($shipping_address_db['id'] == 'birthlist') $shipping_address = new Address('birthlist', $user, "none", "none", "none", "none", "none", 0, "none", "none");
        else $shipping_address = new Address($shipping_address_db['id'], $user, $shipping_address_db['civility'], $shipping_address_db['surname'], $shipping_address_db['firstname'], $shipping_address_db['street'], $shipping_address_db['city'], $shipping_address_db['postal_code'], $shipping_address_db['complement'], $shipping_address_db['company']);

        $query = 'SELECT id, name, discount, type, date_beginning, date_end, number_per_user FROM voucher WHERE id=:voucher_id';
        $con->executeQuery($query, array(':voucher_id' => array($order_db['voucher_id'], PDO::PARAM_STR)));
        $voucher_db = $con->getResults()[0];
        if($voucher_db != null) {
            $voucher = new Voucher($voucher_db['id'], $voucher_db['name'], $voucher_db['discount'], $voucher_db['type'], $voucher_db['date_beginning'], $voucher_db['time_beginning'], $voucher_db['date_end'], $voucher_db['time_end'], $voucher_db['number_per_user']);
        } else $voucher = null;


        $order = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], $voucher, $order_db['birthlist_id']);

        $order->setCancel($order_db['cancel']);

        foreach ($order_items_db as $order_item_db) {
            foreach ($products as $product) {
                $product = (new ProductContainer($product))->getProduct();
                if ($product->getId() == $order_item_db['product_id']) {
                    $order->addOrderItem(new OrderItem($order_item_db['id'], $product, $order_item_db['quantity'], $order_item_db['unit_price']));
                }
            }
        }

        if($order_db['customer_message'] != null) $order->setCustomerMessage($order_db['customer_message']);
        if($order_db['admin_message'] != null) $order->setAdminMessage($order_db['admin_message']);
        if($order_db['new'] != null) $order->setNew($order_db['new']);


        return $order;
    }

    public static function GetOrdersOfCustomer(String $user_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $orders = array();
        $categories = array();

        $query = 'SELECT id, user_id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price,total_price, payment_method, voucher_id, birthlist_id, customer_message, admin_message FROM orders WHERE user_id=:user_id ORDER BY ordering_date DESC ;';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $orders_db = $con->getResults();

        $query = 'SELECT id, order_id, product_id, quantity, unit_price FROM order_item;';
        $con->executeQuery($query);
        $order_items_db = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product_backup ORDER BY name";
        $con->executeQuery($query);
        $products_db = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE user_id=:user_id';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $address_list_db = $con->getResults();

        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $category, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
        }


        foreach ($orders_db as $order_db){
            $address_ok = 0;
            foreach ($address_list_db as $address_db) {
                if ($address_db['id'] == $order_db['shipping_address_id']) {
                    $shipping_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                    $address_ok++;
                }
                if ($address_db['id'] == $order_db['billing_address_id']) {
                    $billing_address = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                    $address_ok++;
                }
                if ($address_ok == 2) {
                    $order = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], null, null);
                    if($order_db['customer_message'] != null) $order->setCustomerMessage($order_db['customer_message']);
                    if($order_db['admin_message'] != null) $order->setAdminMessage($order_db['admin_message']);
                    if($order_db['new'] != null) $order->setNew($order_db['new']);

                    $orders[] = $order;
                    break;
                }
            }
        }

        foreach ($orders as $order) {
            foreach ($order_items_db as $order_item_db) {
                if ($order_item_db['order_id'] == $order->getID()) {
                    foreach ($products as $product) {
                        $product = (new ProductContainer($product))->getProduct();
                        if ($product->getId() == $order_item_db['product_id']) {
                            $order->addOrderItem(new OrderItem($order_item_db['id'], $product, $order_item_db['quantity'], $order_item_db['unit_price']));
                        }
                    }
                }
            }
        }

        return $orders;
    }

    public static function CreateNewInDB(Order $order){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $id = $order->getId();
        $user_id = $order->getCustomer()->getId();
        $shipping_address_id = $order->getShippingAddress()->getId();
        $billing_address_id = $order->getBillingAddress()->getId();
        $ordering_date = date('Y-m-d H:i:s');
        $status = $order->getStatus();
        $shipping_price = $order->getShippingPrice();
        $total_price = $order->getTotalPrice();
        $payment_method = $order->getPaymentMethod();
        if($order->getVoucher() != null) $voucher_id = $order->getVoucher()->getId();
        else $voucher_id = null;
        if($order->getBirthlistID() != null) $birthlist_id = $order->getBirthlistID()->getId();
        else $birthlist_id = null;
        $message = $order->getCustomerMessage();

        $query = "INSERT INTO orders VALUES (:id, :user_id, :shipping_address_id, :billing_address_id, :ordering_date, :status, :shipping_price, :total_price, :payment_method, :voucher_id, :birthlist_id, false, :message, null)";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':user_id' => array($user_id, PDO::PARAM_STR),
            ':shipping_address_id' => array($shipping_address_id, PDO::PARAM_STR),
            ':billing_address_id' => array($billing_address_id, PDO::PARAM_STR),
            ':ordering_date' => array($ordering_date, PDO::PARAM_STR),
            ':status' => array($status, PDO::PARAM_STR),
            ':shipping_price' => array($shipping_price, PDO::PARAM_STR),
            ':total_price' => array($total_price, PDO::PARAM_STR),
            ':payment_method' => array($payment_method, PDO::PARAM_STR),
            ':voucher_id' => array($voucher_id, PDO::PARAM_STR),
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
            ':message' => array($message, PDO::PARAM_STR)
        ));

        $shipping_address = $order->getShippingAddress();
        $billing_address = $order->getBillingAddress();
        $id_shipping_address = $shipping_address->getId();
        $id_billing_address = $billing_address->getId();

        $user_id_shipping_address = $shipping_address->getCustomer()->getId();
        $user_id_billing_address = $billing_address->getCustomer()->getId();

        $civility_shipping_address = $shipping_address->getCivility();
        $civility_billing_address = $billing_address->getCivility();

        $surname_shipping_address = $shipping_address->getSurname();
        $surname_billing_address = $billing_address->getSurname();

        $firstname_shipping_address = $shipping_address->getFirstname();
        $firstname_billing_address = $billing_address->getFirstname();

        $street_shipping_address = $shipping_address->getAddressLine();
        $street_billing_address = $billing_address->getAddressLine();

        $city_shipping_address = $shipping_address->getCity();
        $city_billing_address = $billing_address->getCity();

        $postal_code_shipping_address = $shipping_address->getPostalCode();
        $postal_code_billing_address = $billing_address->getPostalCode();

        $complement_shipping_address = $shipping_address->getComplement();
        $complement_billing_address = $billing_address->getComplement();

        $company_shipping_address = $shipping_address->getCompany();
        $company_billing_address = $billing_address->getCompany();

        $query = "INSERT IGNORE INTO address VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_billing_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_billing_address, PDO::PARAM_STR),
            ':civility' => array($civility_billing_address, PDO::PARAM_INT),
            ':surname' => array($surname_billing_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_billing_address, PDO::PARAM_STR),
            ':street' => array($street_billing_address, PDO::PARAM_STR),
            ':city' => array($city_billing_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_billing_address, PDO::PARAM_STR),
            ':complement' => array($complement_billing_address, PDO::PARAM_STR),
            ':company' => array($company_billing_address, PDO::PARAM_STR),
        ));

        $query = "INSERT IGNORE INTO address_backup VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_billing_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_billing_address, PDO::PARAM_STR),
            ':civility' => array($civility_billing_address, PDO::PARAM_INT),
            ':surname' => array($surname_billing_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_billing_address, PDO::PARAM_STR),
            ':street' => array($street_billing_address, PDO::PARAM_STR),
            ':city' => array($city_billing_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_billing_address, PDO::PARAM_STR),
            ':complement' => array($complement_billing_address, PDO::PARAM_STR),
            ':company' => array($company_billing_address, PDO::PARAM_STR),
        ));

        $query = "INSERT IGNORE INTO address VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_shipping_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_shipping_address, PDO::PARAM_STR),
            ':civility' => array($civility_shipping_address, PDO::PARAM_STR),
            ':surname' => array($surname_shipping_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_shipping_address, PDO::PARAM_STR),
            ':street' => array($street_shipping_address, PDO::PARAM_STR),
            ':city' => array($city_shipping_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_shipping_address, PDO::PARAM_STR),
            ':complement' => array($complement_shipping_address, PDO::PARAM_STR),
            ':company' => array($company_shipping_address, PDO::PARAM_STR),
        ));

        $query = "INSERT IGNORE INTO address_backup VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_shipping_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_shipping_address, PDO::PARAM_STR),
            ':civility' => array($civility_shipping_address, PDO::PARAM_STR),
            ':surname' => array($surname_shipping_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_shipping_address, PDO::PARAM_STR),
            ':street' => array($street_shipping_address, PDO::PARAM_STR),
            ':city' => array($city_shipping_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_shipping_address, PDO::PARAM_STR),
            ':complement' => array($complement_shipping_address, PDO::PARAM_STR),
            ':company' => array($company_shipping_address, PDO::PARAM_STR),
        ));

        foreach ($order->getOrderItems() as $item){

            //ORDER ITEMS
            $item = (new OrderItemContainer($item))->getOrderitem();
            $id = $item->getId();
            $order_id = $order->getId();
            $quantity = $item->getQuantity();
            $unit_price = $item->getUnitPrice();

            //PRODUCTS
            $product_original_id = $item->getProduct()->getIdCopy();
            $product_id = uniqid('order-product-');
            $product_id_copy = $item->getProduct()->getIdCopy();
            $product_name = $item->getProduct()->getName();
            $product_ceo_name = $item->getProduct()->getCeoName();
            $product_price = $item->getProduct()->getPrice();
            $product_stock = $item->getProduct()->getStock();
            $product_description = $item->getProduct()->getDescription();
            $product_ceo_description = $item->getProduct()->getCeoDescription();
            $product_category = "";
            foreach ($item->getProduct()->getCategory() as $category){
                $product_category = $product_category . $category->getName();
            }
            $product_date = $item->getProduct()->getCreationDate();
            $product_image = $item->getProduct()->getImage();
            $number_of_review = $item->getProduct()->getNumberOfReview();
            $number_of_stars = $item->getProduct()->getNumberOfStars();
            $product_reference = $item->getProduct()->getReference();
            $product_tags = $item->getProduct()->getTags();
            $product_hide = $item->getProduct()->getHide();

            $query = "INSERT INTO product_backup VALUES(:backup_id, :product_id, :product_id_copy, :product_name, :product_ceo_name, :product_price, :product_stock, :product_description, :product_ceo_description, :product_category, :product_date, :product_image, :number_of_review, :number_of_stars, :product_reference, :tags, :hide)";
            $con->executeQuery($query, array(
                ':backup_id' => array(uniqid('backup-product-'), PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':product_id_copy' => array($product_id_copy, PDO::PARAM_STR),
                ':product_name' => array($product_name, PDO::PARAM_STR),
                ':product_ceo_name' => array($product_ceo_name, PDO::PARAM_STR),
                ':product_price' => array($product_price, PDO::PARAM_STR),
                ':product_stock' => array($product_stock, PDO::PARAM_STR),
                ':product_description' => array($product_description, PDO::PARAM_STR),
                ':product_ceo_description' => array($product_ceo_description, PDO::PARAM_STR),
                ':product_category' => array($product_category, PDO::PARAM_STR),
                ':product_date' => array($product_date, PDO::PARAM_STR),
                ':product_image' => array($product_image, PDO::PARAM_STR),
                ':number_of_review' => array($number_of_review, PDO::PARAM_STR),
                ':number_of_stars' => array($number_of_stars, PDO::PARAM_STR),
                ':product_reference' => array($product_reference, PDO::PARAM_STR),
                ':tags' => array($product_tags, PDO::PARAM_STR),
                ':hide' => array($product_hide, PDO::PARAM_STR)
            ));

            $query = "INSERT INTO order_item VALUES(:id, :order_id, :product_id, :quantity, :unit_price);";
            $con->executeQuery($query,array(
                ':id' => array($id, PDO::PARAM_STR),
                ':order_id' => array($order_id, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':quantity' => array($quantity, PDO::PARAM_STR),
                ':unit_price' => array($unit_price, PDO::PARAM_STR),
            ));

            $query = "UPDATE product SET stock=stock-:quantity WHERE id_copy=:id;";
            $con->executeQuery($query, array(
                ':quantity' => array($quantity, PDO::PARAM_STR),
                ':id' => array($product_original_id, PDO::PARAM_STR)
            ));
        }

        if(substr($user_id, 0, 7) == "offline"){
            $user = $order->getCustomer();
            $mail = $user->getMail();
            $surname = $user->getSurname();
            $firstname = $user->getFirstname();
            $phone = $user->getPhone();
            $registration_date = $user->getRegistrationDate();

            $query = "INSERT INTO user_no_account VALUES (:id, :mail ,:surname, :firstname, :phone, :registration_date);";
            $con->executeQuery($query, array(
                ':id' => array($user_id, PDO::PARAM_STR),
                ':mail' => array($mail, PDO::PARAM_STR),
                ':surname' => array($surname, PDO::PARAM_STR),
                ':firstname' => array($firstname, PDO::PARAM_STR),
                ':phone' => array($phone, PDO::PARAM_INT),
                ':registration_date' => array($registration_date, PDO::PARAM_STR),
            ));
        }

        $query = "UPDATE notifications SET new_orders=new_orders+1 WHERE key_number=0;";
        $con->executeQuery($query);
    }

    public static function CreateNewOrderFromBirthlistSelectedItems(BirthList $birthlist, string $user_id, Address $billing_address, array $selected_items,float $total_price)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $order_id = $user_id . "-" . uniqid();
        $shipping_address_id = "birthlist";
        $billing_address_id = $billing_address->getId();
        $ordering_date = date('Y-m-d H:i:s');
        $status = 10;
        $shipping_price = 0;
        $payment_method = 1;
        $voucher_id = null;
        $birthlist_id = $birthlist->getId();
        $message = null;

        $query = "INSERT INTO orders VALUES (:id, :user_id, :shipping_address_id, :billing_address_id, :ordering_date, :status, :shipping_price, :total_price, :payment_method, :voucher_id, :birthlist_id, false, :message, null)";
        $con->executeQuery($query, array(
            ':id' => array($order_id, PDO::PARAM_STR),
            ':user_id' => array($user_id, PDO::PARAM_STR),
            ':shipping_address_id' => array($shipping_address_id, PDO::PARAM_STR),
            ':billing_address_id' => array($billing_address_id, PDO::PARAM_STR),
            ':ordering_date' => array($ordering_date, PDO::PARAM_STR),
            ':status' => array($status, PDO::PARAM_STR),
            ':shipping_price' => array($shipping_price, PDO::PARAM_STR),
            ':total_price' => array($total_price, PDO::PARAM_STR),
            ':payment_method' => array($payment_method, PDO::PARAM_STR),
            ':voucher_id' => array($voucher_id, PDO::PARAM_STR),
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
            ':message' => array($message, PDO::PARAM_STR)
        ));

        $id_billing_address = $billing_address->getId();
        $user_id_billing_address = $user_id;
        $civility_billing_address = $billing_address->getCivility();
        $surname_billing_address = $billing_address->getSurname();
        $firstname_billing_address = $billing_address->getFirstname();
        $street_billing_address = $billing_address->getAddressLine();
        $city_billing_address = $billing_address->getCity();
        $postal_code_billing_address = $billing_address->getPostalCode();
        $complement_billing_address = $billing_address->getComplement();
        $company_billing_address = $billing_address->getCompany();

        $query = "INSERT IGNORE INTO address VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_billing_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_billing_address, PDO::PARAM_STR),
            ':civility' => array($civility_billing_address, PDO::PARAM_INT),
            ':surname' => array($surname_billing_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_billing_address, PDO::PARAM_STR),
            ':street' => array($street_billing_address, PDO::PARAM_STR),
            ':city' => array($city_billing_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_billing_address, PDO::PARAM_STR),
            ':complement' => array($complement_billing_address, PDO::PARAM_STR),
            ':company' => array($company_billing_address, PDO::PARAM_STR),
        ));

        $query = "INSERT IGNORE INTO address_backup VALUES(:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)";
        $con->executeQuery($query, array(
            ':id' => array($id_billing_address, PDO::PARAM_STR),
            ':user_id' => array($user_id_billing_address, PDO::PARAM_STR),
            ':civility' => array($civility_billing_address, PDO::PARAM_INT),
            ':surname' => array($surname_billing_address, PDO::PARAM_STR),
            ':firstname' => array($firstname_billing_address, PDO::PARAM_STR),
            ':street' => array($street_billing_address, PDO::PARAM_STR),
            ':city' => array($city_billing_address, PDO::PARAM_STR),
            ':postal_code' => array($postal_code_billing_address, PDO::PARAM_STR),
            ':complement' => array($complement_billing_address, PDO::PARAM_STR),
            ':company' => array($company_billing_address, PDO::PARAM_STR),
        ));

        foreach ($selected_items as $item){

            //ORDER ITEMS
            $item = (new BirthListItemContainer($item))->getBirthlistItem();
            $old_item_id = $item->getId();
            $item->setID($item->getId() . "-" . uniqid() . "-payed");
            $quantity = $item->getQuantity();
            $unit_price = $item->getProduct()->getPrice();

            //PRODUCTS
            $product_original_id = $item->getProduct()->getIdCopy();
            $product_id = uniqid('order-product-');
            $product_id_copy = $item->getProduct()->getIdCopy();
            $product_name = $item->getProduct()->getName();
            $product_price = $item->getProduct()->getPrice();
            $product_stock = $item->getProduct()->getStock();
            $product_description = $item->getProduct()->getDescription();
            $product_ceo_description = $item->getProduct()->getCeoDescription();
            $product_category = $item->getProduct()->getCategory()->getName();
            $product_date = $item->getProduct()->getCreationDate();
            $product_image = $item->getProduct()->getImage();
            $product_reference = $item->getProduct()->getReference();

            $query = "INSERT INTO product_backup VALUES(:backup_id, :product_id, :product_id_copy, :product_name, :product_price, :product_stock, :product_description, :product_ceo_description, :product_category, :product_date, :product_image, :product_reference)";
            $con->executeQuery($query, array(
                ':backup_id' => array(uniqid('backup-product-'), PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':product_id_copy' => array($product_id_copy, PDO::PARAM_STR),
                ':product_name' => array($product_name, PDO::PARAM_STR),
                ':product_price' => array($product_price, PDO::PARAM_STR),
                ':product_stock' => array($product_stock, PDO::PARAM_STR),
                ':product_description' => array($product_description, PDO::PARAM_STR),
                ':product_ceo_description' => array($product_ceo_description, PDO::PARAM_STR),
                ':product_category' => array($product_category, PDO::PARAM_STR),
                ':product_date' => array($product_date, PDO::PARAM_STR),
                ':product_image' => array($product_image, PDO::PARAM_STR),
                ':product_reference' => array($product_reference, PDO::PARAM_STR)
            ));

            $query = "INSERT INTO order_item VALUES(:id, :order_id, :product_id, :quantity, :unit_price);";
            $con->executeQuery($query,array(
                ':id' => array($item->getId(), PDO::PARAM_STR),
                ':order_id' => array($order_id, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':quantity' => array($quantity, PDO::PARAM_STR),
                ':unit_price' => array($unit_price, PDO::PARAM_STR),
            ));

            $query = "UPDATE product SET stock=stock-:quantity WHERE id_copy=:id;";
            $con->executeQuery($query, array(
                ':quantity' => array($quantity, PDO::PARAM_STR),
                ':id' => array($product_original_id, PDO::PARAM_STR)
            ));

            $query = "INSERT INTO birthlist_items VALUES(:id, :birthlist_id, :product_id, :quantity, true, :customer_id, :billing_address_id, :buying_date);";
            $con->executeQuery($query, array(
                ':id' => array($item->getId(), PDO::PARAM_STR),
                ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
                ':product_id' => array($item->getProduct()->getId(), PDO::PARAM_STR),
                ':quantity' => array($quantity, PDO::PARAM_INT),
                ':customer_id' => array($user_id, PDO::PARAM_STR),
                ':billing_address_id' => array($billing_address_id, PDO::PARAM_STR),
                ':buying_date' => array($ordering_date, PDO::PARAM_STR)
            ));

            $query = "UPDATE birthlist_items SET quantity=quantity-:selected_quantity WHERE id=:id_item;";
            $con->executeQuery($query, array(
                ':selected_quantity' => array($item->getQuantity(), PDO::PARAM_INT),
                ':id_item' => array($old_item_id, PDO::PARAM_STR)
            ));
        }

        $query = "DELETE FROM birthlist_items WHERE quantity = 0;";
        $con->executeQuery( $query);

        $_SESSION['selected_items'] = serialize($selected_items);

        $query = "UPDATE notifications SET new_orders=new_orders+1 WHERE key_number=0;";
        $con->executeQuery($query);

        return $order_id;
    }

    public static function UpdateOrder(Order $order){
        if(!$order->getCancel()) {
            global $dblogin, $dbpassword, $dsn;
            $con = new Connexion($dsn, $dblogin, $dbpassword);

            $id = $order->getId();
            $user_id = $order->getCustomer()->getId();
            $shipping_address_id = $order->getShippingAddress()->getId();
            $billing_address_id = $order->getBillingAddress()->getId();
            $ordering_date = $order->getDate();
            $status = $order->getStatus();
            $shipping_price = $order->getShippingPrice();
            $total_price = $order->getTotalPrice();
            $payment_method = $order->getPaymentMethod();
            $admin_message = $order->getAdminMessage();

            if ($order->getVoucher() != null) $voucher_id = $order->getVoucher()->getId();
            else $voucher_id = null;
            if ($order->getBirthlistID() != null) $birthlist_id = $order->getBirthlistID()->getId();
            else $birthlist_id = null;
            if ($status == -1 && $payment_method = 1) $cancel = true;
            else $cancel = false;

            $query = 'UPDATE orders SET user_id=:user_id, shipping_address_id=:shipping_address_id, billing_address_id=:billing_address_id, ordering_date=:ordering_date, status=:status, shipping_price=:shipping_price, total_price=:total_price, payment_method=:payment_method, voucher_id=:voucher_id, birthlist_id=:birthlist_id, cancel=:cancel, admin_message=:admin_message WHERE id=:id;';
            $con->executeQuery($query, array(
                ':id' => array($id, PDO::PARAM_STR),
                ':user_id' => array($user_id, PDO::PARAM_STR),
                ':shipping_address_id' => array($shipping_address_id, PDO::PARAM_STR),
                ':billing_address_id' => array($billing_address_id, PDO::PARAM_STR),
                ':ordering_date' => array($ordering_date, PDO::PARAM_STR),
                ':status' => array($status, PDO::PARAM_STR),
                ':shipping_price' => array($shipping_price, PDO::PARAM_STR),
                ':total_price' => array($total_price, PDO::PARAM_STR),
                ':payment_method' => array($payment_method, PDO::PARAM_STR),
                ':voucher_id' => array($voucher_id, PDO::PARAM_STR),
                ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
                ':cancel' => array($cancel, PDO::PARAM_STR),
                ':admin_message' => array($admin_message, PDO::PARAM_STR)
            ));
        }
    }

    public static function UpdateOrderStatusWithOrderID(String $order_id, int $status, $admin_message){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE orders SET status=:status WHERE id=:order_id;';
        $con->executeQuery($query, array(
            ':status' => array($status, PDO::PARAM_STR),
            ':order_id' => array($order_id,PDO::PARAM_STR)
        ));

        if($status == -11 || $status == -1){
            $query = 'UPDATE orders SET cancel=true WHERE id=:order_id;';
            $con->executeQuery($query, array(
                ':order_id' => array($order_id, PDO::PARAM_STR)
            ));
        }

        if($admin_message != null){
            $query = 'UPDATE orders SET admin_message=:admin_message WHERE id=:order_id;';
            $con->executeQuery($query, array(
                ':admin_message' => array($admin_message, PDO::PARAM_STR),
                ':order_id' => array($order_id, PDO::PARAM_STR)
            ));
        }
    }
}