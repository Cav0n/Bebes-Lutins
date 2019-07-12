<?php

class WishListGateway
{
    public static function GetWishListOfUser(string $user_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, user_id, message FROM wishlist WHERE user_id=:user_id;";
        $con->executeQuery($query, array(':user_id'=>array($user_id, PDO::PARAM_STR)));
        $wishlist = $con->getResults()[0];

        if($wishlist != null){
            $query = "SELECT id, wishlist_id, product_id, message FROM wishlist_items WHERE wishlist_id=:wishlist_id;";
            $con->executeQuery($query, array(':wishlist_id'=>array($wishlist['id'], PDO::PARAM_STR)));
            $wishlist_items = $con->getResults();
        }
    }

    public static function AddIt(String $id, String $name, float $discount, String $type, String $date_beginning, String $time_beginning, String $date_end, String $time_end, int $number_per_user, float $minimal_purchase){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO voucher VALUES(:id, :name, :discount, :type, :date_beginning, :time_beginning, :date_end, :time_end, :number_per_user, :minimal_purchase);";
        $con->executeQuery($query, array(
            ':id'=>array($id, PDO::PARAM_STR),
            ':name'=>array($name, PDO::PARAM_STR),
            ':discount'=>array($discount, PDO::PARAM_STR),
            ':type'=>array($type, PDO::PARAM_STR),
            ':date_beginning'=>array($date_beginning, PDO::PARAM_STR),
            ':time_beginning'=>array($time_beginning, PDO::PARAM_STR),
            ':date_end'=>array($date_end, PDO::PARAM_STR),
            ':time_end'=>array($time_end, PDO::PARAM_STR),
            ':number_per_user'=>array($number_per_user, PDO::PARAM_STR),
            ':minimal_purchase'=>array($minimal_purchase, PDO::PARAM_STR)
        ));
    }
}