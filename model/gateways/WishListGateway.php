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

    /**
     * @param string wishlist_id Identifiant de la liste d'envie
     * @param string product_id Identifiant du produit
     */
    public static function AddItemToWishlist(string $wishlist_id, string $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        //$query = "INSERT INTO "
    }
}