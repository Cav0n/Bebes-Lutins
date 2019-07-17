<?php

class WishListGateway
{
    /**
     * @param string user_id Identifiant de l'utilisateur
     */
    public static function GetWishListOfUser(string $user_id): WishList{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, user_id, message FROM wishlist WHERE user_id=:user_id;";
        $con->executeQuery($query, array(':user_id'=>array($user_id, PDO::PARAM_STR)));
        $results = $con->getResults()[0];
        $wishlist = new WishList($results['id'], $results['user_id'], $results['message']); 

        if($wishlist != null){
            $query = "SELECT id, wishlist_id, product_id, message FROM wishlist_items WHERE wishlist_id=:wishlist_id;";
            $con->executeQuery($query, array(':wishlist_id'=>array($wishlist->getId(), PDO::PARAM_STR)));
            $results = $con->getResults();

            if($results != null){
                foreach ($results as $result) {
                    $wishlist_item = new WishListItem($result['id'], $result['wishlist_id'], $result['product_id'], $result['message']);
                    $wishlist_items[] = $wishlist_item;
                }
    
                $wishlist->setItems($wishlist_items);
            }
        }

        return $wishlist;
    }

    /**
     * @param string wishlist_id Identifiant de la liste d'envie
     * @param string product_id Identifiant du produit
     */
    public static function AddItemToWishlist(string $wishlist_id, string $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO wishlist_items VALUES(:id, :wishlist_id, :product_id, 1);";
        $con->executeQuery($query, array(
            ':id' => array(uniqid('item_'), PDO::PARAM_STR),
            ':wishlist_id' => array($wishlist_id, PDO::PARAM_STR),
            ':product_id' => array($product_id, PDO::PARAM_STR)
        ));
    }

    /**
     * @param string id Identifiant de la liste d'envie
     */
    public static function DeleteItemToWishlist(string $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM whishlist_items WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($id)
        ));
    }
}