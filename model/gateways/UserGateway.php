<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:14
 */

class UserGateway
{
    public static function Register($id, $surname,$firstname,$mail, $phone, $hashed_password, $shopping_cart_id, $birthlist_id, $verification_key, $newsletter){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT mail FROM user WHERE mail=:mail;';
        $con->executeQuery($query, array(':mail' => array($mail, PDO::PARAM_STR)));
        if($con->getResults() != null){
            return "mail";
        }
        else {
            $wishlist_id = uniqid("wishlist_");

            $query = 'INSERT INTO user VALUES (:id, :mail, :hashed_password, :surname, :firstname, :phone, :privilege, :registration_date, :shopping_cart_id, :birthlist_id, :verification_key, true, :newsletter, :wishlist_id);';
            $con->executeQuery($query, array(
                ':id' => array(strtoupper($id), PDO::PARAM_STR),
                ':mail' => array(strtoupper($mail), PDO::PARAM_STR),
                ':hashed_password' => array($hashed_password, PDO::PARAM_STR),
                ':surname' => array(ucfirst($surname), PDO::PARAM_STR),
                ':firstname' => array(ucfirst($firstname), PDO::PARAM_STR),
                ':phone' => array($phone, PDO::PARAM_STR),
                ':privilege' => array(0, PDO::PARAM_INT),
                ':registration_date' => array(date("Y-m-d"), PDO::PARAM_STR),
                ':shopping_cart_id' => array(strtoupper($shopping_cart_id), PDO::PARAM_STR),
                ':birthlist_id' => array(strtoupper($birthlist_id), PDO::PARAM_STR),
                ':verification_key' => array(strtoupper($verification_key), PDO::PARAM_STR),
                ':newsletter' => array($newsletter, PDO::PARAM_STR),
                ':wishlist_id' => array($wishlist_id, PDO::PARAM_STR)
            ));

            $query = 'INSERT INTO shopping_cart VALUES (:id, :user_id, NULL, 0);';
            $con->executeQuery($query, array(
                ':id' => array(strtoupper($shopping_cart_id), PDO::PARAM_STR),
                ':user_id' => array(strtoupper($id), PDO::PARAM_STR)
            ));

            $query = "INSERT INTO wishlist VALUES (:id, :user_id, '');";
            $con->executeQuery($query, array(
                'id' => array($wishlist_id, PDO::PARAM_STR),
                ':user_id' => array($id, PDO::PARAM_STR)
            ));
        }

        $query = "UPDATE notifications SET new_users=new_users+1 WHERE key_number=0;";
        $con->executeQuery($query);

        return "";
    }

    public static function Activation($user_id, $key){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $activated = false;

        $query = 'SELECT verification_key FROM user WHERE id=:id;';
        $con->executeQuery($query, array(
            ':id'=>array($user_id, PDO::PARAM_STR)
        ));

        if($con->getResults()[0] != null){
            $query = 'UPDATE user SET activated=true WHERE id=:user_id AND verification_key=:key;';
            $con->executeQuery($query, array(
                ':user_id'=>array($user_id, PDO::PARAM_STR),
                ':key'=>array($key, PDO::PARAM_STR)
            ));
            return true;
        }
        else return false;
    }

    public static function UpdateVerificationKey($mail, $verification_key) : bool{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT mail FROM user WHERE mail=:mail;';
        $con->executeQuery($query, array(
            ':mail' => array($mail, PDO::PARAM_STR)
        ));

        if(!empty($con->getResults()[0]['mail'])) {
            $query = 'UPDATE user SET verification_key=:verification_key WHERE mail=:mail;';
            $con->executeQuery($query, array(
                ':verification_key' => array($verification_key, PDO::PARAM_STR),
                ':mail' => array($mail, PDO::PARAM_STR)
            ));
            return true;
        }
        else return false;
    }

    public static function UpdatePasswordWithVerificationKey(string $mail, string $key, string $new_password){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE user SET password=:new_password WHERE mail=:mail AND verification_key=:key;';
        $con->executeQuery($query, array(
            ':new_password' => array($new_password, PDO::PARAM_STR),
            ':mail' => array($mail, PDO::PARAM_STR),
            ':key' => array($key, PDO::PARAM_STR)
        ));
    }

    /**
     * @param String $mail
     * @param String $password
     * @return string
     */
    public static function login(String $mail, String $password) : UserConnected{
        try{
            global $dblogin, $dbpassword, $dsn;
            $con = new Connexion($dsn, $dblogin, $dbpassword);

            $products = array();

            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product;";
            $con->executeQuery($query);
            $results = $con->getResults();

            $query ="SELECT name, parent, image, description, rank FROM category";
            $con->executeQuery($query);
            $categories = $con->getResults();

            foreach ($results as $r){
                foreach ($categories as $category) {
                    if($category['name'] == $r['category']){
                        $categ = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
                        $product = new Product($r['id'], $r['id_copy'], $r['name'], $r['ceo_name'], $r['price'], $r['stock'], $r['description'], $r['ceo_description'], $categ, $r['creation_date'], new ImageProduct("null", $r['image']), $r['number_of_review'], $r['number_of_stars'], $r['reference'], $r['tags'], $r['hide']);
                        $products[] = $product;
                    }
                }

            }

            $query = 'SELECT password FROM user WHERE mail=:mail;';
            $con->executeQuery($query, array(':mail' => array(strtoupper($mail), PDO::PARAM_STR)));
            $password_db = $con->getResults();
            if($password_db == null)
                throw new Exception("L'adresse mail est incorrect.");
            else {
                $hashed_password = $password_db[0]['password'];
                if(!password_verify($password, $hashed_password))
                    throw new Exception("Le mot de passe est incorrect.");
                else {
                    $query = 'SELECT id, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user WHERE mail=:mail;';
                    $con->executeQuery($query, array(':mail' => array(strtoupper($mail), PDO::PARAM_STR)));
                    $user_db = $con->getResults()[0];
                    //if($user_db['activated'] == false)
                        //throw new Exception("Votre compte n'est pas activé ! Vous pouvez l'activer en cliquant dans le lien que nous vous avons envoyé par mail.");
                    //else{
                        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $mail, $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

                        // ADRESSES
                        $query = 'SELECT id, civility, surname, firstname, street, city, postal_code, complement, company FROM address WHERE user_id=:user_id;';
                        $con->executeQuery($query, array(
                            ':user_id' => array($user->getId(), PDO::PARAM_STR)
                        ));
                        $address_list_db = $con->getResults();
                        foreach($address_list_db as $address_db){
                            $user->addAddress(new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']));
                        }
                        $query = 'SELECT id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price, total_price, payment_method, voucher_id, birthlist_id FROM orders WHERE user_id=:user_id ORDER BY ordering_date DESC ';
                        $con->executeQuery($query, array(':user_id' => array($user->getId(), PDO::PARAM_STR)));
                        $orders_list_db = $con->getResults();

                        foreach ($orders_list_db as $order_db){
                            $query = 'SELECT id, civility, surname, firstname, street, city, postal_code, complement, company FROM address_backup WHERE id=:id;';
                            $con->executeQuery($query, array(':id' => array($order_db['shipping_address_id'], PDO::PARAM_STR)));
                            $shipping_address = $con->getResults()[0];
                            $shipping_address = new Address($shipping_address['id'], $user, $shipping_address['civility'], $shipping_address['surname'], $shipping_address['firstname'], $shipping_address['street'], $shipping_address['city'], $shipping_address['postal_code'], $shipping_address['complement'], $shipping_address['company']);

                            $query = 'SELECT id, civility, surname, firstname, street, city, postal_code, complement, company FROM address_backup WHERE id=:id;';
                            $con->executeQuery($query, array(':id' => array($order_db['billing_address_id'], PDO::PARAM_STR)));
                            $billing_address = $con->getResults()[0];
                            $billing_address = new Address($billing_address['id'], $user, $billing_address['civility'], $billing_address['surname'], $billing_address['firstname'], $billing_address['street'], $billing_address['city'], $billing_address['postal_code'], $billing_address['complement'], $billing_address['company']);

                            $order = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], null, null);

                            $query = 'SELECT id, product_id, quantity, unit_price FROM order_item WHERE order_id=:order_id;';
                            $con->executeQuery($query, array(':order_id' => array($order->getId(), PDO::PARAM_STR)));
                            $order_items_list_db = $con->getResults();
                            foreach ($order_items_list_db as $order_item_db){
                                $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product_backup WHERE id=:id;";
                                $con->executeQuery($query, array(':id' => array($order_item_db['product_id'], PDO::PARAM_STR)));
                                $product_db = $con->getResults()[0];
                                $order_item = new OrderItem($order_item_db['id'], new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']), $order_item_db['quantity'], $order_item_db['unit_price']);
                                $items_list = $order->getOrderItems();
                                $items_list[] = $order_item;
                                $order->setOrderItems($items_list);
                            }

                            $user->addOrder($order);
                        }

                        $query = 'SELECT id, user_id, voucher_id, total_price FROM shopping_cart WHERE id=:shopping_cart_id AND user_id=:user_id;';
                        $con->executeQuery($query, array(':shopping_cart_id' => array(strtoupper($user_db['shopping_cart_id']), PDO::PARAM_STR), 'user_id' => array(strtoupper($user_db['id']), PDO::PARAM_STR)));
                        $shopping_cart_db = $con->getResults();
                        if($shopping_cart_db != null){
                            $shopping_cart_db = $shopping_cart_db[0];
                            $shopping_cart = new ShoppingCart($shopping_cart_db['id'], $shopping_cart_db['total_price'], null);

                            $query = 'SELECT id, shopping_cart_id, product_id, quantity, price FROM shopping_cart_item WHERE shopping_cart_id=:shopping_cart_id;';
                            $con->executeQuery($query, array(':shopping_cart_id' => array(strtoupper($user_db['shopping_cart_id']), PDO::PARAM_STR)));
                            $shopping_cart_items_db = $con->getResults();
                            if($shopping_cart_items_db != null){
                                foreach ($shopping_cart_items_db as $item){
                                    foreach ($products as $product){
                                        if ($product->getID() == $item['product_id']){
                                            $shopping_cart->addShoppingCartItems(new ShoppingCartItem($item['id'], $product, $item['quantity'], $item['price']));
                                        }
                                    }
                                }
                            }

                            $user->setShoppingCart($shopping_cart);
                        }
                        $user->setNewsletter($user_db['newsletter']);

                        /* IF NO WISHLIST FOR THE USER, SET A NEW WISHLIST */
                        $query = "SELECT id FROM wishlist WHERE user_id=:user_id";
                        $con->executeQuery($query, array(':user_id' => array($user->getId(), PDO::PARAM_STR)));
                        $wishlist = $con->getResults()[0];

                        if($wishlist == null) {
                            $wishlist_id = uniqid('wishlist_');
                            $query = "INSERT INTO wishlist VALUES(:id, :user_id, :message);";
                            $con->executeQuery($query, array(
                                ':id' => array($wishlist_id, PDO::PARAM_STR),
                                ':user_id' => array($user->getId(), PDO::PARAM_STR),
                                ':message' => array('', PDO::PARAM_STR)
                            ));

                            $query = "UPDATE user SET wishlist_id=:wishlist_id;";
                            $con->executeQuery($query, array(':wishlist_id' => array($wishlist_id, PDO::PARAM_STR)));
                            $user->setWishListID($wishlist_id);
                        } else {
                            $user->setWishListID($wishlist['id']);
                        }

                        return $user;
                    //}
                }
            }
        } catch(PDOException $e){
            $_SESSION['error-message'] = $e;
            UtilsModel::load_page("error");
        } catch(Exception $e){
            $_POST['message'] = "<p id='error-message'>".$e->getMessage()."</p>";
            UtilsModel::load_page("login_page");
        }
        return new UserConnected(null, null, null, null, null, null, null, false);
    }

    public static function getAllUsers(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $users = array();

        $query = 'SELECT id, mail, password, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user ORDER BY registration_date DESC;';
        $con->executeQuery($query);
        $users_db = $con->getResults();

        foreach ($users_db as $user_db){
            /*$user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
            $user->setNewsletter($user_db['newsletter']); */
            $users[] = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
        }
        return $users;
    }

    public static function change_informations(String $id, String $surname, String $firstname, String $phone, String $mail){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE user SET surname=:surname, firstname=:firstname, phone=:phone WHERE id=:id;';
        $con->executeQuery($query, array(
            ':surname' => array(ucfirst($surname), PDO::PARAM_STR),
            ':firstname' => array(ucfirst($firstname), PDO::PARAM_STR),
            ':phone' => array($phone, PDO::PARAM_STR),
            ':id' => array(strtoupper($id), PDO::PARAM_STR)
        ));
    }

    public static function change_password(String $id, String $old_password, String $new_password){
        try {
            global $dblogin, $dbpassword, $dsn;
            $con = new Connexion($dsn, $dblogin, $dbpassword);

            $query = 'SELECT password FROM user WHERE id=:id;';
            $con->executeQuery($query, array(':id' => array(strtoupper($id), PDO::PARAM_STR)));
            $password_db = $con->getResults();
            $hashed_password = $password_db[0]['password'];
            if (!password_verify($old_password, $hashed_password))
                throw new Exception("Le mot de passe est incorrect.");

            $query = 'UPDATE user SET password=:new_password WHERE id=:id;';
            $con->executeQuery($query, array(
                ':new_password' => array($new_password, PDO::PARAM_STR),
                ':id' => array($id, PDO::PARAM_STR)
            ));
        } catch(Exception $e){
            $_POST['message_password'] = "<p id='error-message'>".$e->getMessage()."</p>";
            ConnectedModel::load_page('customer-area');
        }
    }

    public static function GetUserByUserID(String $id) : UserConnected{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated, newsletter FROM user WHERE id=:id';
        $con->executeQuery($query, array(':id' => array($id, PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];

        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
        $user->setNewsletter($user_db['newsletter']);
        return $user;
    }

    public static function AddAddressFromOrder(Address $billing, Address $shipping){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'INSERT INTO address VALUES (:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)';
        $con->executeQuery($query, array(
            ':id' => array($billing->getId(), PDO::PARAM_STR),
            ':user_id' => array($billing->getCustomer()->getId(), PDO::PARAM_STR),
            ':civility' => array($billing->getCivility(), PDO::PARAM_STR),
            ':surname' => array($billing->getSurname(), PDO::PARAM_STR),
            ':firstname' => array($billing->getFirstname(), PDO::PARAM_STR),
            ':street' => array($billing->getAddressLine(), PDO::PARAM_STR),
            ':city' => array($billing->getCity(), PDO::PARAM_STR),
            ':postal_code' => array($billing->getPostalCode(), PDO::PARAM_STR),
            ':complement' => array($billing->getComplement(), PDO::PARAM_STR),
            ':company' => array($billing->getCompany(), PDO::PARAM_STR),
        ));

        $query = 'INSERT INTO address VALUES (:id, :user_id, :civility, :surname, :firstname, :street, :city, :postal_code, :complement, :company)';
        $con->executeQuery($query, array(
            ':id' => array($shipping->getId(), PDO::PARAM_STR),
            ':user_id' => array($shipping->getCustomer()->getId(), PDO::PARAM_STR),
            ':civility' => array($shipping->getCivility(), PDO::PARAM_STR),
            ':surname' => array($shipping->getSurname(), PDO::PARAM_STR),
            ':firstname' => array($shipping->getFirstname(), PDO::PARAM_STR),
            ':street' => array($shipping->getAddressLine(), PDO::PARAM_STR),
            ':city' => array($shipping->getCity(), PDO::PARAM_STR),
            ':postal_code' => array($shipping->getPostalCode(), PDO::PARAM_STR),
            ':complement' => array($shipping->getComplement(), PDO::PARAM_STR),
            ':company' => array($shipping->getCompany(), PDO::PARAM_STR),
        ));
    }

    public static function GetAllAddress(UserConnected $user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $shipping_address_list = array();
        $billing_address_list = array();
        $address_list = array();

        $user_id = $user->getId();

        $query = 'SELECT id, civility, surname, firstname, street, city, postal_code, complement, company FROM address WHERE user_id=:user_id;';
        $con->executeQuery($query, array(
            ':user_id' => array($user_id, PDO::PARAM_STR)
        ));

        $address_list_db = $con->getResults();
        foreach ($address_list_db as $address_db){
            if (strpos($address_db['id'], "-billing")){
                $billing_address_list[] = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                $address_list['billing'] = $billing_address_list;
            }
            if (strpos($address_db['id'], "-shipping")){
                $shipping_address_list[] = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
                $address_list['shipping'] = $shipping_address_list;
             }
        }
        return $address_list;
    }

    public static function GetAllAddressForUser(UserConnected $user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $address_list = array();

        $user_id = $user->getId();

        $query = 'SELECT id, civility, surname, firstname, street, city, postal_code, complement, company FROM address WHERE user_id=:user_id;';
        $con->executeQuery($query, array(
            ':user_id' => array($user_id, PDO::PARAM_STR)
        ));

        $address_list_db = $con->getResults();
        foreach ($address_list_db as $address_db){
            $address_list[] = new Address($address_db['id'], $user, $address_db['civility'], $address_db['surname'], $address_db['firstname'], $address_db['street'], $address_db['city'], $address_db['postal_code'], $address_db['complement'], $address_db['company']);
        }
        return $address_list;
    }

    public static function GetOrders(UserConnected $user){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $user_id = $user->getId();
        $orders = array();
        $categories = array();

        $query = 'SELECT id, user_id, shipping_address_id, billing_address_id, ordering_date, status, shipping_price,total_price, payment_method, voucher_id, birthlist_id FROM orders WHERE user_id=:user_id ORDER BY ordering_date DESC ;';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $orders_db = $con->getResults();

        $query = 'SELECT id, order_id, product_id, quantity, unit_price FROM order_item;';
        $con->executeQuery($query);
        $order_items_db = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product order by name;";
        $con->executeQuery($query);
        $products_db = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();

        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE user_id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $address_list_db = $con->getResults();

        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
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
                    $orders[] = new Order($order_db['id'], $user, $shipping_address, $billing_address, $order_db['ordering_date'], $order_db['status'], $order_db['shipping_price'], $order_db['total_price'], $order_db['payment_method'], null, null);
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

    public static function InvertNewsLetter(string $user_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT newsletter FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(
            ':user_id' => array($user_id, PDO::PARAM_STR)
        ));
        $newsletter = $con->getResults()[0]['newsletter'];

        if($newsletter == 1) $newsletter_new = 0;
        if($newsletter == 0) $newsletter_new = 1;

        $query = 'UPDATE user SET newsletter=:newsletter WHERE id=:id;';
        $con->executeQuery($query, array(
            ':newsletter' => array($newsletter_new, PDO::PARAM_STR),
            ':id' => array($user_id, PDO::PARAM_STR)
        ));
    }
}