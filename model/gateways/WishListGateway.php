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

                    $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:product_id;";
                    $con->executeQuery($query, array(':product_id' => array($wishlist_item->getProductID(), PDO::PARAM_STR)));
                    $r = $con->getResults()[0];
            
                    $query = "SELECT name, parent, image, description, rank, tags, private FROM category";
                    $con->executeQuery($query);
                    $categories = $con->getResults();
            
                    $query = "SELECT image, product_id FROM thumbnails WHERE product_id=:product_id;";
                    $con->executeQuery($query, array(':product_id' => array($wishlist_item->getProductID(), PDO::PARAM_STR)));
                    $thumbnails_list_db = $con->getResults();
            
                    $product_categories = explode(";",$r['category']);
                    $categ = [];
                    foreach ($categories as $category) {
                        foreach ($product_categories as $product_category) {
                            if ($category['name'] == $product_category) {
                                $categ[] = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank'], $category['tags'], $category['private']);
                            }
                        }
                    }
                    $product = new Product($r['id'], $r['id_copy'], $r['name'], $r['ceo_name'], $r['price'], $r['stock'], $r['description'], $r['ceo_description'], $categ, $r['creation_date'], new ImageProduct("null", $r['image']), $r['number_of_review'], $r['number_of_stars'], $r['reference'], $r['tags'], $r['hide']);
                    if ($thumbnails_list_db != null) {
                        foreach ($thumbnails_list_db as $t) {
                            if ($product->getId() == $t['product_id']) {
                                $product->getImage()->addThumbnail(new Image($t['image']));
                            }
                        }
                    }

                    $wishlist_item->setProduct($product);

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

        $query = 'SELECT id FROM wishlist_items WHERE product_id=:product_id;';
        $con->executeQuery($query, array(
            ':product_id'=>array($product_id, PDO::PARAM_STR)
        ));
        if($con->getResults()[0] != null) return -1;

        $query = "INSERT INTO wishlist_items VALUES(:id, :wishlist_id, :product_id, 1);";
        $con->executeQuery($query, array(
            ':id' => array(uniqid('item_'), PDO::PARAM_STR),
            ':wishlist_id' => array($wishlist_id, PDO::PARAM_STR),
            ':product_id' => array($product_id, PDO::PARAM_STR)
        ));
        return 0;
    }

    /**
     * @param string id Identifiant de la liste d'envie
     */
    public static function DeleteItemFromWishlist(string $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM wishlist_items WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR)
        ));
    }
}