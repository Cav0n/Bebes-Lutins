<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:14
 */

class CategoryGateway
{
    public static function GetCategories() : array{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        $results = array();

        $query ="SELECT name, parent, image, description, rank FROM category ORDER BY rank";
        $con->executeQuery($query);
        $categories = $con->getResults();

        foreach ($categories as $category){
            $categ = new Category($category['name'], $category['parent'], new ImageCategory($category['image']), $category['description'], $category['rank']);
            $results[] = $categ;
        }

        return $results;
    }

    public static function AddCategory(String $name, $parent, String $image, String $description, int $rank){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "INSERT INTO category VALUES (:name, :parent, :image, :description, :rank)";
        $con->executeQuery($query, array(
            ':name' => array($name, PDO::PARAM_STR),
            ':parent' =>array($parent, PDO::PARAM_STR),
            ':image' => array($image, PDO::PARAM_STR),
            ':description' => array($description, PDO::PARAM_STR),
            ':rank' => array($rank, PDO::PARAM_STR)
        ));

        $query = "INSERT INTO category_backup VALUES (:id, :name, :parent, :image, :description, :rank)";
        $con->executeQuery($query, array(
            ':id' => array(uniqid('backup-category-'), PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':parent' =>array($parent, PDO::PARAM_STR),
            ':image' => array($image, PDO::PARAM_STR),
            ':description' => array($description, PDO::PARAM_STR),
            ':rank' => array($rank, PDO::PARAM_STR)
        ));
    }

    public static function EditCategory(String $name, string $parent, String $image, String $description, String $old_name, int $rank){
        global $dblogin, $dbpassword,$dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = "UPDATE product SET category=:category_name WHERE category=:old_name;";
        $con->executeQuery($query, array(
            ':category_name' => array($name, PDO::PARAM_STR),
            ':old_name' => array($old_name, PDO::PARAM_STR)
        ));

        $query = "UPDATE category SET name=:name, parent=:parent, image=:image, description=:description, rank=:rank WHERE name=:old_name";
        $con->executeQuery($query, array(
            ':name' => array($name, PDO::PARAM_STR),
            ':parent' => array($parent, PDO::PARAM_STR),
            ':image' => array($image, PDO::PARAM_STR),
            ':description' => array($description, PDO::PARAM_STR),
            ':old_name' => array($old_name, PDO::PARAM_STR),
            ':rank' => array($rank, PDO::PARAM_STR)
        ));
    }

    public static function DeleteCategory(String $name){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);
        
        $category_name = str_replace("_", "’", str_replace( "-"," ", $name));

        $query = "SELECT name FROM category";
        $con->executeQuery($query, array(':name' => array($category_name, PDO::PARAM_STR)));
        $categories = $con->getResults();
        foreach ($categories as $category){
            if(str_replace("_", "’", str_replace( "-"," ", $category['name'])) == str_replace("_", "’", str_replace( "-"," ", $name))){
                $name_accented = $category['name'];
                break;
            }
        }

        if($name_accented != null){
            $query = "DELETE FROM product WHERE category=:name";
            $con->executeQuery($query, array(':name' => array($name_accented, PDO::PARAM_STR)));

            $query = "DELETE FROM category WHERE parent=:name OR name=:name";
            $con->executeQuery($query, array(':name' => array($name_accented, PDO::PARAM_STR)));
        }
    }

    public static function GetCategory(String $name) : Category{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'SELECT name, parent, image, description, rank FROM category WHERE name=:name';
        $con->executeQuery($query, array(':name' => array($name, PDO::PARAM_STR)));
        $category_db = $con->getResults()[0];

        return new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
    }

    public static function SearchCategoryByName(String $category_name) : Category{
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $category_name = UtilsModel::replace_accent($category_name);

        $query = 'SELECT name, parent, image, description, rank FROM category';
        $con->executeQuery($query);
        $categories_db = $con->getResults();

        foreach ($categories_db as $category_db){
            if(UtilsModel::replace_accent($category_db['name']) == $category_name){
                $category = new Category($category_db['name'], $category_db['parent'], new ImageCategory($category_db['image']), $category_db['description'], $category_db['rank']);
            }
        }

        return $category;
    }

    public static function ChangeRank(String $category_name_1, int $rank_1, String $category_name_2, int $rank_2){
        global $dblogin, $dbpassword, $dsn;
        $con = new Connexion($dsn, $dblogin, $dbpassword);

        $query = 'UPDATE category SET rank=:rank_1 WHERE name=:category_name_1';
        $con->executeQuery($query, array(
            ':rank_1' => array($rank_1 => PDO::PARAM_STR),
            ':category_name_1' => array($category_name_1, PDO::PARAM_STR)
        ));

        $query = 'UPDATE category SET rank=:rank_2 WHERE name=:category_name_2';
        $con->executeQuery($query, array(
            ':rank_2' => array($rank_2 => PDO::PARAM_STR),
            ':category_name_2' => array($category_name_2, PDO::PARAM_STR)
        ));
    }
}