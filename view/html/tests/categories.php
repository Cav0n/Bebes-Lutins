<?php
global $view_rep;

// /**
//  * CATEGORIES BACKUP
//  */
// $categories = CategoryGateway::GetCategories();
// foreach($categories as $category){
//     $category = (new CategoryContainer($category))->getCategory();
//     $hide = $category->getPrivate();

//     if($category->getParent() != null) 
//     $parent = "(SELECT p.id FROM categories AS p WHERE p.name=\"" . $category->getParent() . "\")";
//     else $parent = "NULL";

//     if($hide == null) $hide = 0;

//     echo "
//     <p style='margin:0'>
//         INSERT INTO categories (id, name, description, mainImage, rank, isHidden, isDeleted, parent_id, created_at, updated_at)
//         VALUES (
//             '".$category->getID()."',
//             '". str_replace("'", "''", $category->getName()) ."',
//             '". str_replace("'", "''", $category->getDescription()) ."',
//             '". $category->getImage() ."',
//             ".$category->getRank().",
//             ".$hide.",
//             0,
//             ".$parent.",
//             NOW(), NOW()
//          );
//     </p><BR>";
// }

// /**
//  * CATEGORIES BACKUP
//  */
// $categories = CategoryGateway::GetCategoriesBackup();
// foreach($categories as $category){
//     $category = (new CategoryContainer($category))->getCategory();
//     $hide = $category->getPrivate();

//     if($category->getParent() != null) 
//     $parent = "(SELECT p.id FROM categories AS p WHERE p.name=\"" . $category->getParent() . "\")";
//     else $parent = "NULL";

//     if($hide == null) $hide = 0;

//     echo "
//     <p style='margin:0'>
//         INSERT INTO categories (id, name, description, mainImage, rank, isHidden, isDeleted, parent_id, created_at, updated_at)
//         VALUES (
//             '".$category->getID()."',
//             '". str_replace("'", "''", $category->getName()) ."',
//             '". str_replace("'", "''", $category->getDescription()) ."',
//             '". $category->getImage() ."',
//             ".$category->getRank().",
//             ".$hide.",
//             0,
//             ".$parent.",
//             NOW(), NOW()
//          );
//     </p><BR>";
// }

// /**
//  * PRODUCTS
//  */
// $products = ProductGateway::GetProducts2();
// foreach($products as $product){
//     $product = (new ProductContainer($product))->getProduct();
    
//     $hide = $product->getHide();
//     if($hide == null) $hide = 0;

//     $stock = $product->getStock();
//     if($stock < 0) $stock = 0;

//     echo "
//     <p style='margin:0'>
//         INSERT INTO products (id, reference, name, description, mainImage, stock, price, isHidden, isDeleted, reviewsCount, reviewsStars, created_at, updated_at)
//         VALUE (
//             '". $product->getID2() ."',
//             '". $product->getReference() ."',
//             '". str_replace("'", "''", $product->getName()) ."',
//             '". str_replace("'", "''", htmlspecialchars($product->getDescription())) ."',
//             '". $product->getImage()->getName() ."',
//             ". $stock .",
//             ". $product->getPrice() .",
//             ". $hide .",
//             0,
//             0,
//             0,
//             '".$product->getCreationDate() . " 00:00:00"."',
//             NOW()
//         );
//     </p>";
// }

// /**
//  * PRODUCTS BACKUP
//  */
// $products = ProductGateway::GetProductsBackup();
// foreach($products as $product){
//     $product = (new ProductContainer($product))->getProduct();
    
//     $hide = $product->getHide();
//     if($hide == null) $hide = 0;

//     $stock = $product->getStock();
//     if($stock < 0) $stock = 0;

//     echo "
//     <p style='margin:0'>
//         INSERT INTO products (id, reference, name, description, mainImage, stock, price, isHidden, isDeleted, reviewsCount, reviewsStars, created_at, updated_at)
//         VALUE (
//             '". $product->getID2() ."',
//             '". $product->getReference() ."',
//             '". str_replace("'", "''", $product->getName()) ."',
//             '". str_replace("'", "''", htmlspecialchars($product->getDescription())) ."',
//             '". $product->getImage()->getName() ."',
//             ". $stock .",
//             ". $product->getPrice() .",
//             ". $hide .",
//             0,
//             0,
//             0,
//             '".$product->getCreationDate() . " 00:00:00"."',
//             NOW()
//         );
//     </p>";
// }

// /**
//  * PRODUCTS CATEGORIES
//  */
// $products = ProductGateway::GetProducts2();
// foreach($products as $product){
//     foreach($product->getCategory() as $category){
//         echo "
//         <p style='margin:0'>
//             INSERT INTO category_product (category_id, product_id, created_at, updated_at)
//             VALUES (
//                 '". $category->getID() ."',
//                 '". $product->getID2() ."',
//                 NOW(), NOW()
//             );
//         </p>";
//     }
// }

// $products = ProductGateway::GetProductsBackup();
// foreach($products as $product){
//     foreach($product->getCategory() as $category){
//         echo "
//         <p style='margin:0'>
//             INSERT INTO category_product (category_id, product_id, created_at, updated_at)
//             VALUES (
//                 '". $category->getID() ."',
//                 '". $product->getID2() ."',
//                 NOW(), NOW()
//             );
//         </p>";
//     }
// }

// /**
//  * PRODUCTS IMAGES
//  */
// $products = ProductGateway::GetProducts2();
// foreach($products as $product){
//     echo "
//     <p style='margin:0'>
//         INSERT INTO images (name, size, created_at, updated_at)
//         VALUES (
//             '". $product->getImage()->getName() ."',
//             ". filesize(getcwd().'/view/assets/images/products/'. $product->getImage()->getName()) .",
//             NOW(),NOW()
//         );
//     </p>";

//     echo "
//     <p style='margin:0'>
//         INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//         VALUES (
//             (SELECT i.id FROM images AS i WHERE i.name=\"" . $product->getImage()->getName() . "\"),
//             \"" . $product->getID2() . "\",
//             NOW(), NOW()
//         );
//     </p>";

//     foreach($product->getImage()->getThumbnails() as $thumbnail){
//         if(strpos($thumbnail->getName(), ' ') !== false){
//             echo "
//             <p style='margin:0'>
//                 INSERT INTO images (name, size, created_at, updated_at)
//                 VALUES (
//                     '". $thumbnail->getName() ."',
//                     ". filesize(getcwd().'/view/assets/images/thumbnails/'. $thumbnail->getName()) .",
//                     NOW(),NOW()
//                 );
//             </p>";

//             echo "
//             <p style='margin:0'>
//                 INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//                 VALUES (
//                     (SELECT i.id FROM images AS i WHERE i.name=\"" . $thumbnail->getName() . "\"),
//                     \"" . $product->getID2() . "\",
//                     NOW(), NOW()
//                 );
//             </p>";
//         }
//     }
// }

// $products = ProductGateway::GetProductsBackup();
// foreach($products as $product){
//     echo "
//     <p style='margin:0'>
//         INSERT INTO images (name, size, created_at, updated_at)
//         VALUES (
//             '". $product->getImage()->getName() ."',
//             ". filesize(getcwd().'/view/assets/images/products/'. $product->getImage()->getName()) .",
//             NOW(),NOW()
//         );
//     </p>";

//     echo "
//     <p style='margin:0'>
//         INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//         VALUES (
//             (SELECT i.id FROM images AS i WHERE i.name=\"" . $product->getImage()->getName() . "\"),
//             \"" . $product->getID2() . "\",
//             NOW(), NOW()
//         );
//     </p>";

//     foreach($product->getImage()->getThumbnails() as $thumbnail){
//         if(strpos($thumbnail->getName(), ' ') !== false){
//         echo "
//             <p style='margin:0'>
//                 INSERT INTO images (name, size, created_at, updated_at)
//                 VALUES (
//                     '". $thumbnail->getName() ."',
//                     ". filesize(getcwd().'/view/assets/images/thumbnails/'. $thumbnail->getName()) .",
//                     NOW(),NOW()
//                 );
//             </p>";

//         echo "
//             <p style='margin:0'>
//                 INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//                 VALUES (
//                     (SELECT i.id FROM images AS i WHERE i.name=\"" . $thumbnail->getName() . "\"),
//                     \"" . $product->getID2() . "\",
//                     NOW(), NOW()
//                 );
//             </p>";
//         }
//     }
// }

// /**
//  * PRODUCTS TAGS
//  */
// $products = ProductGateway::GetProducts2();
// foreach($products as $product){
//     foreach($product->getTagsArray() as $tag){
//         if($tag != ''){
//             echo "
//             <p style='margin:0'>
//                 INSERT INTO tags (name, created_at, updated_at)
//                 VALUES (
//                     '". trim($tag) ."',
//                     NOW(), NOW()
//                 );
//             </p>";

//             echo "
//             <p style='margin:0'>
//                 INSERT INTO product_tag (product_id, tag_id, created_at, updated_at)
//                 VALUES (
//                     (SELECT p.id FROM products AS p WHERE p.name=\"" . $product->getName() . "\"),
//                     (SELECT t.id FROM tags AS t WHERE t.name=\"" . $tag . "\"),
//                     NOW(), NOW()
//                 );
//             </p>";
//         } 
//     }
// }

// /**
//  * USERS
//  */
// $users = UserGateway::getAllUsers();
// foreach($users as $user){
//     if($user->getPrivilege() > 0) $isAdmin = 1;
//     else $isAdmin = 0;
//     echo "
//     <p>
//         INSERT INTO users (id, email, password, firstname, lastname, wantNewsletter, phone, birthdate, isAdmin, privileges, created_at, updated_at)
//         VALUES (
//             '". $user->getID() ."',
//             '". $user->getMail() ."',
//             '". $user->getPassword() ."',
//             '". $user->getFirstname() ."',
//             '". $user->getSurname() ."',
//             '". $user->isNewsletter() ."',
//             '". $user->getPhoneWithoutSpaces() ."',
//             NULL,
//             '". $isAdmin ."',
//             '". $user->getPrivilege() ."',
//             '". $user->getRegistrationDate() . " 00:00:00" ."',
//             NOW()
//         );
//     </p>";
// }

/**
 * ADDRESSES
 */
$addresses = AddressGateway::GetAllAddress();
foreach($addresses as $address){
    echo "
    <p>
        INSERT INTO addresses (id, firstname, lastname, civility, street, zipCode, city, complement, company, isDeleted, email, phone, user_id, created_at, updated_at)
        VALUES (
            '". $address->getID() ."',
            '". str_replace("'", "''", $address->getFirstname()) ."',
            '". str_replace("'", "''", $address->getSurname()) ."',
            '". $address->getCivility() ."',
            '". str_replace("'", "''", $address->getAddressLine()) ."',
            '". $address->getPostalCode() ."',
            '". str_replace("'", "''", $address->getCity()) ."',
            '". str_replace("'", "''", $address->getComplement()) ."',
            '". str_replace("'", "''", $address->getCompany()) ."',
            NULL,
            '". $address->getCustomer()->getMail() ."',
            '". $address->getCustomer()->getPhoneWithoutSpaces() ."',
            '". $address->getCustomer()->getID() ."',
            NOW(), NOW()
        );
    </p>";
}

?>