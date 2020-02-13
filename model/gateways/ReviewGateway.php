<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 08/03/2019
 * Time: 09:03
 */

class  ReviewGateway
{
    public static function AddReviewForProduct(String $id, String $product_id, String $customer_id, String $customer_name, int $mark, $text, bool $declined){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $date = date('Y-m-d H:i:s');

        try {
            $query = "INSERT INTO review VALUES(:id, :product_id, :customer_id, :customer_name, :mark, :text, FALSE, :date, :declined);";
            $con->executeQuery($query, array(
                ':id' => array($id, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR),
                ':customer_id' => array($customer_id, PDO::PARAM_STR),
                ':customer_name' => array($customer_name, PDO::PARAM_STR),
                ':mark' => array($mark, PDO::PARAM_STR),
                ':text' => array($text, PDO::PARAM_STR),
                ':date' => array($date, PDO::PARAM_STR),
                ':declined' => array($declined, PDO::PARAM_BOOL)
            ));
        } catch (PDOException $e){
            echo $e;
        }

        if(!$declined) {
            $query = "UPDATE product SET number_of_review = number_of_review + 1, number_of_stars = number_of_stars + :mark WHERE id=:product_id;";
            $con->executeQuery($query, array(
                ':mark' => array($mark, PDO::PARAM_STR),
                ':product_id' => array($product_id, PDO::PARAM_STR)
            ));
        }

        $query = "UPDATE notifications SET new_reviews=new_reviews+1 WHERE key_number=0;";
        $con->executeQuery($query);
    }

    public static function GetAllReviewForProduct(String $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $reviews_list = array();

        $query = "SELECT id, product_id, customer_id, customer_name, mark, text, has_response, posted_date, declined FROM review WHERE product_id=:product_id ORDER BY mark desc;";
        $con->executeQuery($query, array(
            ':product_id' => array($product_id, PDO::PARAM_STR)
        ));

        $reviews = $con->getResults();

        foreach ($reviews as $review){
            $customer_id = $review['customer_id'];
            $product_id = $review['product_id'];

            $query = 'SELECT id, mail, password, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user WHERE id=:customer_id;';
            $con->executeQuery($query, array(':customer_id' => array($customer_id, PDO::PARAM_STR)));
            $user_db = $con->getResults()[0];

            $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
            $con->executeQuery($query, array(':id' => array($product_id, PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);

            $reviews_list[] = new Review($review['id'], $product, $user, $review['customer_name'], $review['mark'], $review['text'], $review['has_response'], $review['posted_date'], $review['declined']);
        }

        return $reviews_list;
    }

    public static function GetAllAcceptedReview(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $reviews_list = array();

        $query = "SELECT id, product_id, customer_id, customer_name, mark, text, has_response, posted_date, declined FROM review WHERE declined=FALSE ORDER BY mark desc;";
        $con->executeQuery($query);

        $reviews = $con->getResults();

        foreach ($reviews as $review){
            $customer_id = $review['customer_id'];
            $product_id = $review['product_id'];

            $query = 'SELECT id, mail, password, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user WHERE id=:customer_id;';
            $con->executeQuery($query, array(':customer_id' => array($customer_id, PDO::PARAM_STR)));
            $user_db = $con->getResults()[0];

            $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
            $con->executeQuery($query, array(':id' => array($product_id, PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);

            $reviews_list[] = new Review($review['id'], $product, $user, $review['customer_name'], $review['mark'], $review['text'], $review['has_response'], $review['posted_date'], $review['declined']);
        }
        return $reviews_list;
    }

    public static function GetAllDeclinedReview(){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $reviews_list = array();

        $query = "SELECT id, product_id, customer_id, customer_name, mark, text, has_response, posted_date, declined FROM review WHERE declined=TRUE ORDER BY mark desc;";
        $con->executeQuery($query);

        $reviews = $con->getResults();

        foreach ($reviews as $review){
            $customer_id = $review['customer_id'];
            $product_id = $review['product_id'];

            $query = 'SELECT id, mail, password, surname, firstname, phone, privilege, registration_date, shopping_cart_id, birthlist_id, verification_key, activated, newsletter FROM user WHERE id=:customer_id;';
            $con->executeQuery($query, array(':customer_id' => array($customer_id, PDO::PARAM_STR)));
            $user_db = $con->getResults()[0];

            $user = new UserConnected($user_db['id'], $user_db['surname'], $user_db['firstname'], $user_db['mail'], $user_db['phone'], $user_db['privilege'], $user_db['registration_date'], $user_db['activated']);

            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
            $con->executeQuery($query, array(':id' => array($product_id, PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);

            $reviews_list[] = new Review($review['id'], $product, $user, $review['customer_name'], $review['mark'], $review['text'], $review['has_response'], $review['posted_date'], $review['declined']);
        }
        return $reviews_list;
    }

    public static function DeleteReview(String $review_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, product_id, customer_id, customer_name, mark, text, declined FROM review WHERE id=:review_id;";
        $con->executeQuery($query, array(
            ':review_id' => array($review_id, PDO::PARAM_STR)
        ));
        $review = $con->getResults()[0];

        $query = "DELETE FROM review WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($review_id, PDO::PARAM_STR)
        ));

        if($review['declined'] == 0) {
            $query = "UPDATE product SET number_of_review = number_of_review - 1, number_of_stars = number_of_stars - :mark WHERE id=:product_id;";
            $con->executeQuery($query, array(
                ':mark' => array($review['mark'], PDO::PARAM_STR),
                ':product_id' => array($review['product_id'], PDO::PARAM_STR)
            ));
        }
    }
}