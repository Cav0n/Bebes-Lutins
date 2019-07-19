<?php


class ProductGateway
{
    public static function GetProducts(): array
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $products = array();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY name";
        $con->executeQuery($query);
        $results = $con->getResults();

        $query = "SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT image, product_id FROM thumbnails;";
        $con->executeQuery($query);
        $thumbnails_list_db = $con->getResults();

        foreach ($results as $r){
            foreach ($categories as $category) {
                if($category['name'] == $r['category']){
                    $categ = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
                    $product = new Product($r['id'], $r['id_copy'], $r['name'], $r['ceo_name'], $r['price'], $r['stock'], $r['description'], $r['ceo_description'], $categ, $r['creation_date'], new ImageProduct("null", $r['image']), $r['number_of_review'], $r['number_of_stars'], $r['reference'], $r['tags'], $r['hide']);

                    if($thumbnails_list_db != null){
                        foreach ($thumbnails_list_db as $t){
                            if($product->getId() == $t['product_id']){
                                $product->getImage()->addThumbnail(new Image($t['image']));
                            }
                        }
                    }
                    $products[] = $product;
                }
            }
        }

        return $products;
    }

    public static function GetProducts2(): array
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $products = array();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY name";
        $con->executeQuery($query);
        $results = $con->getResults();

        $query = "SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT image, product_id FROM thumbnails;";
        $con->executeQuery($query);
        $thumbnails_list_db = $con->getResults();

        foreach ($results as $r){
            $product_categories = explode(";",$r['category']);
            $categ = [];
            foreach ($categories as $category) {
                foreach ($product_categories as $product_category) {
                    if ($category['name'] == $product_category) {
                        $categ[] = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
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
            $products[] = $product;
        }

        return $products;
    }

    public static function GetProductsSortedBy(string $sorting_type){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $products = array();

        switch($sorting_type){
            case 'name':
                $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY name";
                $con->executeQuery($query);
                $results = $con->getResults();
                break;

            case 'price':
                $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY price";
                $con->executeQuery($query);
                $results = $con->getResults();
                break;

            default:
                break;
        }


    }

    public static function GetProductWithIndex(int $index, int $numberOfProducts){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $products = array();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY name LIMIT :indexProduct,:offset";
        $con->executeQuery($query, array(
            ':indexProduct' => array($index, PDO::PARAM_INT),
            ':offset' => array($index + $numberOfProducts, PDO::PARAM_INT)
        ));
        $results = $con->getResults();

        $query = "SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT image, product_id FROM thumbnails;";
        $con->executeQuery($query);
        $thumbnails_list_db = $con->getResults();

        foreach ($results as $r){
            $product_categories = explode(";",$r['category']);
            $categ = [];
            foreach ($categories as $category) {
                foreach ($product_categories as $product_category) {
                    if ($category['name'] == $product_category) {
                        $categ[] = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
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
            $products[] = $product;
        }

        return $products;
    }

    public static function GetHighlightedProducts()
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $results = array();

        $query = "SELECT id, product_id, position FROM highlighted_products ORDER BY position";
        $con->executeQuery($query);
        $highlighted_products = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product ORDER BY name";
        $con->executeQuery($query);
        $products = $con->getResults();

        $query = "SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT image, product_id FROM thumbnails;";
        $con->executeQuery($query);
        $thumbnails_list_db = $con->getResults();

        foreach ($highlighted_products as $highlighted_product) {
            foreach ($products as $product) {
                if($highlighted_product['product_id'] == $product['id']) {
                    foreach ($categories as $category) {
                        if ($category['name'] == $product['category']) {
                            $categ = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
                            $p = new Product($product['id'], $product['id_copy'], $product['name'], $product['ceo_name'], $product['price'], $product['stock'], $product['description'], $product['ceo_description'], $categ, $product['creation_date'], new ImageProduct("null", $product['image']), $product['number_of_review'], $product['number_of_stars'], $product['reference'], $product['tags'], $product['hide']);

                            if ($thumbnails_list_db != null) {
                                foreach ($thumbnails_list_db as $t) {
                                    if ($p->getId() == $t['product_id']) {
                                        $p->getImage()->addThumbnail(new Image($t['image']));
                                    }
                                }
                            }
                            $results[] = $p;
                        }
                    }
                }
            }
        }

        return $results;
    }

    public static function GetHighlightedProducts2()
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        
        $highlighted_products = array();

        $query = "SELECT id, product_id, position FROM highlighted_products ORDER BY position";
        $con->executeQuery($query);
        $results = $con->getResults();

        foreach ($results as $r) {
            $product_id = $r['product_id'];
            $categ = array();

            $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:product_id;";
            $con->executeQuery($query, array(':product_id' => array($product_id, PDO::PARAM_STR)));
            $product_db = $con->getResults()[0];

            $product_categories = explode(';', $product_db['category']);
            foreach($product_categories as $product_category) {
                if($product_category != ''){ // Security because explode function can get empty string after ';'
                $query = "SELECT name, parent, image, description, rank FROM category WHERE name=:category_name;";
                $con->executeQuery($query, array(':category_name' => array($product_category, PDO::PARAM_STR)));
                $category = $con->getResults()[0];
                $categ[] = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);}
            }

            $product = new Product(
                $product_db['id'], 
                $product_db['id_copy'], 
                $product_db['name'], 
                $product_db['ceo_name'],
                $product_db['price'], 
                $product_db['stock'], 
                $product_db['description'], 
                $product_db['ceo_description'], 
                $categ, 
                $product_db['creation_date'], 
                new ImageProduct("null", $product_db['image']), 
                $product_db['number_of_review'], 
                $product_db['number_of_stars'], 
                $product_db['reference'], 
                $product_db['tags'], 
                $product_db['hide']
            );

            $query = "SELECT image, product_id FROM thumbnails WHERE product_id=:product_id;";
            $con->executeQuery($query, array(':product_id' => array($product_id, PDO::PARAM_STR)));
            $thumbnails_list_db = $con->getResults();

            foreach ($thumbnails_list_db as $t) {
                $product->getImage()->addThumbnail(new Image($t['image']));
            }

            $highlighted_products[] = $product;
        }

        return $highlighted_products;
    }

    public static function AddProduct(String $id, String $name, String $ceo_name, float $price, int $stock, String $description, String $ceo_description, String $category, String $creation_date, String $image, String $reference, $tags, bool $hide, string $thumbnails_name){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO product VALUES (:id, :id_copy, :name, :ceo_name, :price, :stock, :description, :ceo_description, :category, :creation_date, :image, 0, 0, :reference, :tags, :hide)";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':id_copy' => array($id, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':ceo_name' => array($ceo_name, PDO::PARAM_STR),
            ':price' => array($price, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT),
            ':description' => array($description, PDO::PARAM_STR),
            ':ceo_description' => array($ceo_description, PDO::PARAM_STR),
            ':category' => array($category, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR),
            ':image' => array($image, PDO::PARAM_STR),
            ':reference' => array($reference, PDO::PARAM_STR),
            ':tags' => array($tags, PDO::PARAM_STR),
            ':hide' => array($hide, PDO::PARAM_BOOL)
        ));

        $query = "INSERT INTO product_backup VALUES (:id_backup, :id, :id_copy, :name, :ceo_name, :price, :stock, :description, :ceo_description, :category, :creation_date, :image, 0, 0, :reference, :tags, :hide)";
        $con->executeQuery($query, array(
            ':id_backup' => array(uniqid('backup-product-'), PDO::PARAM_STR),
            ':id' => array($id, PDO::PARAM_STR),
            ':id_copy' => array($id, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':ceo_name' => array($ceo_name, PDO::PARAM_STR),
            ':price' => array($price, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT),
            ':description' => array($description, PDO::PARAM_STR),
            ':ceo_description' => array($ceo_description, PDO::PARAM_STR),
            ':category' => array($category, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR),
            ':image' => array($image, PDO::PARAM_STR),
            ':reference' => array($reference, PDO::PARAM_STR),
            ':tags' => array($tags, PDO::PARAM_STR),
            ':hide' => array($hide, PDO::PARAM_BOOL)
        ));

        $thumbnails = explode(";",$thumbnails_name);

        foreach($thumbnails as $thumbnail){
            if(preg_replace('/\s+/', '', $thumbnail) != null && preg_replace('/\s+/', '', $thumbnail) != "") {
                $thumbnail_id = uniqid("thumbnails-".$id."-");

                $query = "INSERT INTO thumbnails VALUES(:id, :product_id, :image);";
                $con->executeQuery($query, array(
                    ':id' => array($thumbnail_id, PDO::PARAM_STR),
                    ':product_id' => array($id, PDO::PARAM_STR),
                    ':image' => array($thumbnail, PDO::PARAM_STR),
                ));
            }
        }
    }

    public static function AddHighlightProduct(String $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT count(*) FROM highlighted_products;";
        $con->executeQuery($query);
        $position = $con->getResults();

        $query = "INSERT INTO highlighted_products VALUES (:id, :product_id, :position);";
        $con->executeQuery($query, array(
            ':id' => array(uniqid('highlight-'), PDO::PARAM_STR),
            ':product_id' => array($product_id, PDO::PARAM_STR),
            ':position' => array($position, PDO::PARAM_INT)
        ));
    }

    public static function RemoveHighlightProduct(String $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM highlighted_products WHERE product_id=:product_id;";
        $con->executeQuery($query, array(
            ':product_id' => array($product_id, PDO::PARAM_STR)
        ));
    }

    public static function UpdateProduct($id_copy, $id, $name, $ceo_name, $price, $stock, $description, $ceo_description, $creation_date, $image_name, $reference, $tags, $hide){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE product SET name=:name, ceo_name=:ceo_name, price=:price, stock=:stock, description=:description, ceo_description=:ceo_description, creation_date=:creation_date, image=:image_name, reference=:reference, tags=:tags, hide=:hide WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':ceo_name' => array($ceo_name, PDO::PARAM_STR),
            ':price' => array($price, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT),
            ':description' => array($description, PDO::PARAM_STR),
            ':ceo_description' => array($ceo_description, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR),
            ':image_name' => array($image_name, PDO::PARAM_STR),
            ':reference' => array($reference, PDO::PARAM_STR),
            ':tags' => array($tags, PDO::PARAM_STR),
            ':hide' => array($hide, PDO::PARAM_BOOL)
        ));

        $query = "UPDATE product SET name=:name, ceo_name=:ceo_name, price=:price, stock=:stock, description=:description, ceo_description=:ceo_description, creation_date=:creation_date, image=:image_name, reference=:reference, tags=:tags, hide=:hide WHERE id_copy=:id_copy;";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':ceo_name' => array($ceo_name, PDO::PARAM_STR),
            ':price' => array($price, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT),
            ':description' => array($description, PDO::PARAM_STR),
            ':ceo_description' => array($ceo_description, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR),
            ':image_name' => array($image_name, PDO::PARAM_STR),
            ':reference' => array($reference, PDO::PARAM_STR),
            ':tags' => array($tags, PDO::PARAM_STR),
            ':hide' => array($hide, PDO::PARAM_BOOL),
            ":id_copy" => array($id_copy, PDO::PARAM_STR)
        ));
    }

    public static function UpdateProduct2($id_copy, $id, $name, $categories, $ceo_name, $price, $stock, $description, $ceo_description, $creation_date, $image_name, $reference, $tags, $hide, $thumbnails_name){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE product SET name=:name, category=:categories, ceo_name=:ceo_name, price=:price, stock=:stock, description=:description, ceo_description=:ceo_description, creation_date=:creation_date, image=:image_name, reference=:reference, tags=:tags, hide=:hide WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':categories' => array($categories, PDO::PARAM_STR),
            ':ceo_name' => array($ceo_name, PDO::PARAM_STR),
            ':price' => array($price, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT),
            ':description' => array($description, PDO::PARAM_STR),
            ':ceo_description' => array($ceo_description, PDO::PARAM_STR),
            ':creation_date' => array($creation_date, PDO::PARAM_STR),
            ':image_name' => array($image_name, PDO::PARAM_STR),
            ':reference' => array($reference, PDO::PARAM_STR),
            ':tags' => array($tags, PDO::PARAM_STR),
            ':hide' => array($hide, PDO::PARAM_BOOL)
        ));

        $query = "DELETE FROM thumbnails WHERE product_id=:id";
        $con->executeQuery($query, array('id' => array($id, PDO::PARAM_STR)));

        $thumbnails = explode(";",$thumbnails_name);

        foreach($thumbnails as $thumbnail){
            if(preg_replace('/\s+/', '', $thumbnail) != null && preg_replace('/\s+/', '', $thumbnail) != "") {
                $thumbnail_id = uniqid("thumbnails-".$id."-");

                $query = "INSERT INTO thumbnails VALUES(:id, :product_id, :image);";
                $con->executeQuery($query, array(
                    ':id' => array($thumbnail_id, PDO::PARAM_STR),
                    ':product_id' => array($id, PDO::PARAM_STR),
                    ':image' => array($thumbnail, PDO::PARAM_STR),
                ));
            }
        }
    }

    public static function CloneProduct(String $category, String $id_copy, String $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        // PRODUCT INFOS

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id_copy=:id_copy;";
        $con->executeQuery($query, array(':id_copy' => array($id_copy, PDO::PARAM_STR)));
        $product_db = $con->getResults()[0];

        $query = "INSERT INTO product VALUES (:id, :id_copy, :name, :ceo_name, :price, :stock, :description, :ceo_description, :category, :creation_date, :image, 0, 0, :reference, :tags, :hide)";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':id_copy' => array($id_copy, PDO::PARAM_STR),
            ':name' => array($product_db['name'], PDO::PARAM_STR),
            ':ceo_name' => array($product_db['ceo_name'], PDO::PARAM_STR),
            ':price' => array($product_db['price'], PDO::PARAM_STR),
            ':stock' => array($product_db['stock'], PDO::PARAM_INT),
            ':description' => array($product_db['description'], PDO::PARAM_STR),
            ':ceo_description' => array($product_db['ceo_description'], PDO::PARAM_STR),
            ':category' => array($category, PDO::PARAM_STR),
            ':creation_date' => array($product_db['creation_date'], PDO::PARAM_STR),
            ':image' => array($product_db['image'], PDO::PARAM_STR),
            ':reference' => array($product_db['reference'], PDO::PARAM_STR),
            ':tags' => array($product_db['tags'], PDO::PARAM_STR),
            ':hide' => array($product_db['hide'], PDO::PARAM_BOOL)
        ));
    }

    public static function CopyProduct(String $category, String $old_id, String $new_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
        $con->executeQuery($query, array(':id' => array($old_id, PDO::PARAM_STR)));
        $product_db = $con->getResults()[0];

        $query = "INSERT INTO product VALUES (:id, :id_copy, :name, :ceo_name, :price, :stock, :description, :ceo_description, :category, :creation_date, :image, 0, 0, :reference, :tags, :hide)";
        $con->executeQuery($query, array(
            ':id' => array($new_id, PDO::PARAM_STR),
            ':id_copy' => array($new_id, PDO::PARAM_STR),
            ':name' => array($product_db['name'], PDO::PARAM_STR),
            ':ceo_name' => array($product_db['ceo_name'], PDO::PARAM_STR),
            ':price' => array($product_db['price'], PDO::PARAM_STR),
            ':stock' => array($product_db['stock'], PDO::PARAM_INT),
            ':description' => array($product_db['description'], PDO::PARAM_STR),
            ':ceo_description' => array($product_db['ceo_description'], PDO::PARAM_STR),
            ':category' => array($category, PDO::PARAM_STR),
            ':creation_date' => array($product_db['creation_date'], PDO::PARAM_STR),
            ':image' => array($product_db['image'], PDO::PARAM_STR),
            ':reference' => array($product_db['reference'], PDO::PARAM_STR),
            ':tags' => array($product_db['tags'], PDO::PARAM_STR),
            ':hide' => array($product_db['hide'], PDO::PARAM_BOOL)
        ));
    }

    public static function MoveProduct(String $new_category, String $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE product SET category=:category WHERE id=:id;";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':category' => array($new_category, PDO::PARAM_STR)
        ));
    }

    public static function DeleteProduct(String $id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM product WHERE id=:id";
        $con->executeQuery($query, array(':id' => array($id, PDO::PARAM_STR)));

        $query = "DELETE FROM thumbnails WHERE product_id=:id";
        $con->executeQuery($query, array('id' => array($id, PDO::PARAM_STR)));
    }

    public static function SearchProductByID(String $id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query ="SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
        $con->executeQuery($query, array('id' => array($id, PDO::PARAM_STR)));
        $product_db = $con->getResults()[0];

        foreach ($categories as $category) {
            if($category['name'] == $product_db['category']){
                $categ = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
                $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);
            }
        }

        $query = "SELECT image FROM thumbnails WHERE product_id=:id;";
        $con->executeQuery($query, array(':id' => array($product->getId(), PDO::PARAM_STR)));
        $thumbnails_db = $con->getResults();
        if($thumbnails_db != null){
            foreach ($thumbnails_db as $t){
                $product->getImage()->addThumbnail(new Image($t['image']));
            }
        }

        return $product;
    }

    public static function SearchProductByID2(String $id)
    {
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query ="SELECT name, parent, image, description, rank FROM category";
        $con->executeQuery($query);
        $categories = $con->getResults();

        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE id=:id;";
        $con->executeQuery($query, array('id' => array($id, PDO::PARAM_STR)));
        $product_db = $con->getResults()[0];

        $categ = [];
        $product_categories = explode(';', $product_db['category']);

        foreach ($product_categories as $product_category){
            foreach ($categories as $category) {
                if($category['name'] == $product_category){
                    $categ[] = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
                }
            }
        }

        $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $categ, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);

        $query = "SELECT image FROM thumbnails WHERE product_id=:id;";
        $con->executeQuery($query, array(':id' => array($product->getId(), PDO::PARAM_STR)));
        $thumbnails_db = $con->getResults();
        if($thumbnails_db != null){
            foreach ($thumbnails_db as $t){
                $product->getImage()->addThumbnail(new Image($t['image']));
            }
        }

        return $product;
    }

    public static function SearchProductsByCategory(Category $category){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $product_list = array();

        $category_name = $category->getName();
        $query = "SELECT id, id_copy, name, ceo_name,price, stock, description, ceo_description, category, creation_date, image, number_of_review, number_of_stars, reference, tags, hide FROM product WHERE category LIKE '%$category_name%';";
        $con->executeQuery($query, array(':category_name' => array($category_name, PDO::PARAM_STR)));
        $products_list_db = $con->getResults();

        foreach ($products_list_db as $product_db){
            $product = new Product($product_db['id'], $product_db['id_copy'], $product_db['name'], $product_db['ceo_name'], $product_db['price'], $product_db['stock'], $product_db['description'], $product_db['ceo_description'], $category, $product_db['creation_date'], new ImageProduct("null", $product_db['image']), $product_db['number_of_review'], $product_db['number_of_stars'], $product_db['reference'], $product_db['tags'], $product_db['hide']);

            $product_list[] = $product;
        }

        return $product_list;
    }

    public static function AddThumbnails($id, $thumbnails_name, $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO thumbnails VALUES(:id, :product_id, :image);";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':product_id' => array($product_id, PDO::PARAM_STR),
            ':image' => array($thumbnails_name, PDO::PARAM_STR),
        ));
    }

    public static function DeleteThumbnail(String $thumbnail_name, String $product_id){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "DELETE FROM thumbnails WHERE image=:thumbnail_name AND product_id=:product_id;";
        $con->executeQuery($query, array(
            ':thumbnail_name' => array($thumbnail_name,PDO::PARAM_STR),
            ':product_id' => array($product_id, PDO::PARAM_STR)
        ));
    }

    public static function UpdateStock(String $id, int $stock){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE product SET stock=:stock WHERE id=:id";
        $con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_STR),
            ':stock' => array($stock, PDO::PARAM_INT)
        ));
    }
}