<?php


class BirthlistGateway
{
    public static function GetBirthlistByCustomerID(String $customer_id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $products = array();
        $categories = array();
        $birthlist_items = array();

        $query = "SELECT id, user_id, creation_date, father_name, mother_name, message, shipping_address_id, step FROM birthlist WHERE user_id=:customer_id;";
        $con->executeQuery($query, array(
            ':customer_id' => array($customer_id, PDO::PARAM_STR)
        ));
        $birthlist_db = $con->getResults()[0];

        if($birthlist_db == null) return null;

        $query = "SELECT id, birthlist_id, product_id, quantity, payed, customer_id, billing_address_id, buying_date FROM birthlist_items WHERE birthlist_id=:birthlist_id ORDER BY payed ASC ;";
        $con->executeQuery($query, array(
            ':birthlist_id' => array($birthlist_db['id'], PDO::PARAM_STR)
        ));
        $birthlist_db_items = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category';
        $con->executeQuery($query);
        $categories_db = $con->getResults();
        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($birthlist_db_items as $birthlist_db_item)
        {
            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
            $con->executeQuery($query, array(':product_id' => array($birthlist_db_item['product_id'], PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();

                if($category->getName() == $product_db['category']){
                    $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
            $birthlist_item = new BirthListItem($birthlist_db_item['id'], $birthlist_db_item['birthlist_id'], $product, $birthlist_db_item['quantity']);
            if($birthlist_db_item['payed']) $birthlist_item->setPayed(true); else $birthlist_item->setPayed(false);
            if($birthlist_db_item['customer_id'] != null){
                $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
                $con->executeQuery($query, array(':user_id' => array($birthlist_db_item['customer_id'], PDO::PARAM_STR)));
                $user_db = $con->getResults()[0];
                $birthlist_item->setCustomer(new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']));
            }
            if($birthlist_db_item['billing_address_id'] != null){
                $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:billing_address_id';
                $con->executeQuery($query, array(':billing_address_id' => array($birthlist_db_item['billing_address_id'], PDO::PARAM_STR)));
                $billing_address_db = $con->getResults()[0];
                $birthlist_item->setBillingAddress(new Address($billing_address_db['id'], $birthlist_item->getCustomer(), $billing_address_db['civility'], $billing_address_db['surname'], $billing_address_db['firstname'], $billing_address_db['street'], $billing_address_db['city'], $billing_address_db['postal_code'], $billing_address_db['complement'], $billing_address_db['company']));
            }
            if($birthlist_db_items['buying_date'] != null){
                try {
                    $birthlist_item->setBuyingDate(new DateTime($birthlist_db_item['buying_date']));
                } catch (Exception $e) {

                }
            }

            $birthlist_items[] = $birthlist_item;
        }

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($birthlist_db['user_id'], PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];
        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

        try {
            $creation_date = new DateTime($birthlist_db['creation_date']);
        } catch (Exception $e) {

        }

        $birthlist = new BirthList($birthlist_db['id'], $user, $creation_date);

        if($birthlist_db['father_name'] != null) $birthlist->setFatherName($birthlist_db['father_name']);
        if($birthlist_db['mother_name'] != null) $birthlist->setMotherName($birthlist_db['mother_name']);
        if($birthlist_db['message'] != null) $birthlist->setMessage($birthlist_db['message']);
        if($birthlist_db['shipping_address_id'] != null)
        {
            $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:shipping_address_id';
            $con->executeQuery($query, array(':shipping_address_id' => array($birthlist_db['shipping_address_id'], PDO::PARAM_STR)));
            $shipping_address_db = $con->getResults()[0];
            $birthlist->setShippingAddress(new Address($shipping_address_db['id'], $user, $shipping_address_db['civility'], $shipping_address_db['surname'], $shipping_address_db['firstname'], $shipping_address_db['street'], $shipping_address_db['city'], $shipping_address_db['postal_code'], $shipping_address_db['complement'], $shipping_address_db['company']));
        }

        if(!empty($birthlist_items)) $birthlist->setItems($birthlist_items);
        $birthlist->setStep($birthlist_db['step']);

        return $birthlist;
    }

    public static function GetBirthlistByID(string $birthlist_id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $products = array();
        $categories = array();
        $birthlist_items = array();

        $query = "SELECT id, user_id, creation_date, father_name, mother_name, message, shipping_address_id, step FROM birthlist WHERE id=:birthlist_id;";
        $con->executeQuery($query, array(
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR)
        ));
        $birthlist_db = $con->getResults()[0];

        if($birthlist_db == null) return null;

        $query = "SELECT id, birthlist_id, product_id, quantity, payed, customer_id, billing_address_id, buying_date FROM birthlist_items WHERE birthlist_id=:birthlist_id ORDER BY payed ASC ;";
        $con->executeQuery($query, array(
            ':birthlist_id' => array($birthlist_db['id'], PDO::PARAM_STR)
        ));
        $birthlist_db_items = $con->getResults();

        $query = 'SELECT name, parent, image, description, rank FROM category';
        $con->executeQuery($query);
        $categories_db = $con->getResults();
        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        foreach ($birthlist_db_items as $birthlist_db_item)
        {
            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
            $con->executeQuery($query, array(':id' => array($birthlist_db_item['product_id'], PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();

                if($category->getName() == $product_db['category']){
                    $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
            $birthlist_item = new BirthListItem($birthlist_db_item['id'], $birthlist_db_item['birthlist_id'], $product, $birthlist_db_item['quantity']);
            if($birthlist_db_item['payed']) $birthlist_item->setPayed(true); else $birthlist_item->setPayed(false);
            if($birthlist_db_item['customer_id'] != null){
                $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
                $con->executeQuery($query, array(':user_id' => array($birthlist_db_item['customer_id'], PDO::PARAM_STR)));
                $user_db = $con->getResults()[0];
                $birthlist_item->setCustomer(new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']));
            }
            if($birthlist_db_item['billing_address_id'] != null){
                $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:billing_address_id';
                $con->executeQuery($query, array(':billing_address_id' => array($birthlist_db_item['billing_address_id'], PDO::PARAM_STR)));
                $billing_address_db = $con->getResults()[0];
                $birthlist_item->setBillingAddress(new Address($billing_address_db['id'], $birthlist_item->getCustomer(), $billing_address_db['civility'], $billing_address_db['surname'], $billing_address_db['firstname'], $billing_address_db['street'], $billing_address_db['city'], $billing_address_db['postal_code'], $billing_address_db['complement'], $billing_address_db['company']));
            }
            if($birthlist_db_items['buying_date'] != null){
                try {
                    $birthlist_item->setBuyingDate(new DateTime($birthlist_db_item['buying_date']));
                } catch (Exception $e) {

                }
            }

            $birthlist_items[] = $birthlist_item;
        }

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($birthlist_db['user_id'], PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];
        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

        try {
            $creation_date = new DateTime($birthlist_db['creation_date']);
        } catch (Exception $e) {
        }

        $birthlist = new BirthList($birthlist_db['id'], $user, $creation_date);

        if($birthlist_db['father_name'] != null) $birthlist->setFatherName($birthlist_db['father_name']);
        if($birthlist_db['mother_name'] != null) $birthlist->setMotherName($birthlist_db['mother_name']);
        if($birthlist_db['message'] != null) $birthlist->setMessage($birthlist_db['message']);
        if($birthlist_db['shipping_address_id'] != null)
        {
            $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:shipping_address_id';
            $con->executeQuery($query, array(':shipping_address_id' => array($birthlist_db['shipping_address_id'], PDO::PARAM_STR)));
            $shipping_address_db = $con->getResults()[0];
            $birthlist->setShippingAddress(new Address($shipping_address_db['id'], $user, $shipping_address_db['civility'], $shipping_address_db['surname'], $shipping_address_db['firstname'], $shipping_address_db['street'], $shipping_address_db['city'], $shipping_address_db['postal_code'], $shipping_address_db['complement'], $shipping_address_db['company']));
        }

        if(!empty($birthlist_items)) $birthlist->setItems($birthlist_items);
        $birthlist->setStep($birthlist_db['step']);

        return $birthlist;
    }

    public static function InitBirthlist(string $user_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
        $con->executeQuery($query, array(':user_id' => array($user_id, PDO::PARAM_STR)));
        $user_db = $con->getResults()[0];

        $id = uniqid("BIRTHLIST-");
        $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);
        $creation_date = date('Y-m-d H:i:s');

        $query = 'INSERT INTO birthlist VALUES (:id, :user_id, :creation_date, null, null, null, null, 1);';
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':user_id' => array($user_id, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR)
        ));
    }

    public static function CreationBirthlist(string $birthlist_id, string $mother_name, string $father_name, string $message){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE birthlist SET mother_name=:mother_name, father_name=:father_name, message=:message, step=2 WHERE id=:birthlist_id;';
        $con->executeQuery($query, array(
            ':mother_name' => array($mother_name, PDO::PARAM_STR),
            ':father_name' => array($father_name, PDO::PARAM_STR),
            ':message' => array($message, PDO::PARAM_STR),
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR)
        ));
    }

    public static function AddProductArrayToItemList(string $birthlist_id, $products)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        foreach ($products as $product_id){
            $query = 'INSERT INTO birthlist_items VALUES(:id, :birthlist_id, :product_id, 1, FALSE, NULL, NULL, NULL);';
            $con->executeQuery($query, array(
                ':id' => array(uniqid("item-"), PDO::PARAM_STR),
                ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR)
            ));
        }

        $query = 'UPDATE birthlist SET step=3 WHERE id=:birthlist_id;';
        $con->executeQuery($query, array(
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR)
        ));
    }

    public static function DeleteNotSelectedProducts($birthlist_id, $products)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin,$dbpassword);

        foreach ($products as $product_id){
            $query = 'DELETE FROM birthlist_items WHERE birthlist_id=:birthlist_id AND product_id=:product_id;';
            $con->executeQuery($query, array(
                ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
                'product_id' => array($product_id, PDO::PARAM_STR)
            ));
        }
    }

    public static function UpdateStep(string $birthlist_id, int $step)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin,$dbpassword);

        $query = 'UPDATE birthlist SET step=:step WHERE id=:birthlist_id;';
        $con->executeQuery($query, array(
            ':step' => array($step, PDO::PARAM_INT),
            ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR)
        ));
    }

    public static function UpdateQuantityOfItem($item_id, $quantity)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin,$dbpassword);

        $query = 'UPDATE birthlist_items SET quantity=:quantity WHERE id=:item_id;';
        $con->executeQuery($query, array(
            ':quantity' => array($quantity, PDO::PARAM_INT),
            ':item_id' => array($item_id, PDO::PARAM_STR)
        ));
    }

    public static function GetItemsWithItemsID(array $items_id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin,$dbpassword);

        $products = array();
        $categories = array();
        $birthlist_items = array();

        $query = 'SELECT name, parent, image, description, rank FROM category_backup';
        $con->executeQuery($query);
        $categories_db = $con->getResults();
        foreach ($categories_db as $category_db){
            $categories[] = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
        }

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product";
        $con->executeQuery($query);
        $products_db = $con->getResults();
        foreach ($products_db as $product_db){
            foreach ($categories as $category){
                $category = (new CategoryContainer($category))->getCategory();
                if($category->getName() == $product_db['category']){
                    $products[] = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
                }
            }
        }

        foreach ($items_id as $item_id) {
            $query = "SELECT id, birthlist_id, product_id, quantity, payed, customer_id, billing_address_id, buying_date FROM birthlist_items WHERE id=:item_id ORDER BY payed ASC ;";
            $con->executeQuery($query, array(
                ':item_id' => array($item_id, PDO::PARAM_STR)
            ));
            $birthlist_db_items[] = $con->getResults()[0];
        }
        foreach ($birthlist_db_items as $birthlist_db_item)
        {
            foreach ($products as $product){
                $product = (new ProductContainer($product))->getProduct();
                if($product->getId() == $birthlist_db_item['product_id']){
                    $birthlist_item = new BirthListItem($birthlist_db_item['id'], $birthlist_db_item['birthlist_id'], $product, $birthlist_db_item['quantity']);
                    if($birthlist_db_item['payed']) $birthlist_item->setPayed(true); else $birthlist_item->setPayed(false);
                    if($birthlist_db_item['customer_id'] != null){
                        $query = 'SELECT id, mail, surname, firstname, phone, privilege, registration_date, activated FROM user WHERE id=:user_id;';
                        $con->executeQuery($query, array(':user_id' => array($birthlist_db_item['customer_id'], PDO::PARAM_STR)));
                        $user_db = $con->getResults()[0];
                        $birthlist_item->setCustomer(new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']));
                    }
                    if($birthlist_db_item['billing_address_id'] != null){
                        $query = 'SELECT id, user_id, civility, surname, firstname, street, city, civility, postal_code, complement, company FROM address_backup WHERE id=:billing_address_id';
                        $con->executeQuery($query, array(':billing_address_id' => array($birthlist_db_item['billing_address_id'], PDO::PARAM_STR)));
                        $billing_address_db = $con->getResults()[0];
                        $birthlist_item->setBillingAddress(new Address($billing_address_db['id'], $birthlist_item->getCustomer(), $billing_address_db['civility'], $billing_address_db['surname'], $billing_address_db['firstname'], $billing_address_db['street'], $billing_address_db['city'], $billing_address_db['postal_code'], $billing_address_db['complement'], $billing_address_db['company']));
                    }
                    if($birthlist_db_items['buying_date'] != null){
                        try {
                            $birthlist_item->setBuyingDate(new DateTime($birthlist_db_item['buying_date']));
                        } catch (Exception $e) {

                        }
                    }

                    $birthlist_items[] = $birthlist_item;
                    break;
                }
            }
        }
        if(!empty($birthlist_items)) return $birthlist_items;
        else return null;
    }

    public static function CancelSelectedItems($birthlist_id, $selected_items)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin,$dbpassword);

        foreach ($selected_items as $item){
            $item = (new BirthListItemContainer($item))->getBirthlistItem();
            $new_quantity = $item->getQuantity();
            $product_id = $item->getProduct()->getId();
            $old_item_array = explode("-", $item->getId());
            $old_item_id = $old_item_array[0] . '-' . $old_item_array[1];

            $query = 'SELECT quantity FROM birthlist_items WHERE id=:item_id;';
            $con->executeQuery($query, array(
                ':item_id' => array($old_item_id, PDO::PARAM_STR)
            ));
            $old_quantity = $con->getResults()[0]['quantity'];

            if($old_quantity != null){
                $query = "DELETE FROM birthlist_items WHERE id=:old_item_id;";
                $con->executeQuery($query, array(
                    ':old_item_id' => array($old_item_id, PDO::PARAM_STR)
                ));
            } else $old_quantity = 0;

            $quantity = $new_quantity + $old_quantity;

            $query = "INSERT INTO birthlist_items VALUES (:id, :birthlist_id, :product_id, :quantity, FALSE, NULL, NULL, NULL);";
            $con->executeQuery($query, array(
                ':id' => array('item-'.uniqid(), PDO::PARAM_STR),
                ':birthlist_id' => array($birthlist_id, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':quantity' => array($quantity, PDO::PARAM_INT)
            ));

            $query = "DELETE FROM birthlist_items WHERE id=:item_id;";
            $con->executeQuery($query, array(
                ':item_id' => array($item->getId(), PDO::PARAM_STR)
            ));
        }
    }
}