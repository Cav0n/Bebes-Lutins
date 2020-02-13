<?php
global $view_rep;

// /**
//  * CATEGORIES
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
//         echo "
//         <p style='margin:0'>
//             INSERT INTO images (name, size, created_at, updated_at)
//             VALUES (
//                 '". $thumbnail ."',
//                 ". filesize(getcwd().'/view/assets/images/thumbnails/'. $thumbnail) .",
//                 NOW(),NOW()
//             );
//         </p>";

//         echo "
//         <p style='margin:0'>
//             INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//             VALUES (
//                 (SELECT i.id FROM images AS i WHERE i.name=\"" . $thumbnail . "\"),
//                 \"" . $product->getID2() . "\",
//                 NOW(), NOW()
//             );
//         </p>";
//     }
// }

// $products = ProductGateway::GetProductsBackup();
// foreach($products as $product){
//     if(file_exists(getcwd().'/view/assets/images/products/'. $product->getImage()->getName())){
//         echo "
//         <p style='margin:0'>
//             INSERT INTO images (name, size, created_at, updated_at)
//             VALUES (
//                 '". $product->getImage()->getName() ."',
//                 ". filesize(getcwd().'/view/assets/images/products/'. $product->getImage()->getName()) .",
//                 NOW(),NOW()
//             );
//         </p>";

//         echo "
//         <p style='margin:0'>
//             INSERT INTO image_product (image_id, product_id, created_at, updated_at)
//             VALUES (
//                 (SELECT i.id FROM images AS i WHERE i.name=\"" . $product->getImage()->getName() . "\"),
//                 \"" . $product->getID2() . "\",
//                 NOW(), NOW()
//             );
//         </p>";
//     }

//     foreach($product->getImage()->getThumbnails() as $thumbnail){
//         if(strpos($thumbnail->getName(), ' ') !== false && (file_exists(getcwd().'/view/assets/images/products/'. $product->getImage()->getName())) ){
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
//                     (SELECT t.id FROM tags AS t WHERE t.name=\"" . trim($tag) . "\"),
//                     NOW(), NOW()
//                 );
//             </p>";
//         } 
//     }
// }

/**
 * USERS
 */
$users = UserGateway::getAllUsers();
foreach($users as $user){
    if($user->getPrivilege() > 0) $isAdmin = 1;
    else $isAdmin = 0;
    echo "
    <p>
        INSERT INTO users (id, email, password, firstname, lastname, wantNewsletter, phone, birthdate, isAdmin, privileges, created_at, updated_at)
        VALUES (
            '". $user->getID() ."',
            '". $user->getMail() ."',
            '". $user->getPassword() ."',
            '". $user->getFirstname() ."',
            '". $user->getSurname() ."',
            '". $user->isNewsletter() ."',
            '". $user->getPhoneWithoutSpaces() ."',
            NULL,
            '". $isAdmin ."',
            '". $user->getPrivilege() ."',
            '". $user->getRegistrationDate() . " 00:00:00" ."',
            NOW()
        );
    </p>";
}

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

/**
 * VOUCHERS
 */
$vouchers = VoucherGateway::GetAllVoucher();
foreach($vouchers as $voucher){
    $voucher = (new VoucherContainer($voucher))->getVoucher();
    $is_deleted = 0;

    if($voucher->getDeleted() != null && $voucher->getDeleted() > 0 ) $is_deleted = 1;

    echo "
    <p>
        INSERT INTO vouchers (id, code, discountValue, discountType, dateFirst, dateLast, 
        minimalPrice, maxUsage, isDeleted, availability, created_at, updated_at)
        VALUES (
            '".$voucher->getID()."',
            '".$voucher->getName()."',
            ".$voucher->getDiscount().",
            ".$voucher->getType().",
            '".$voucher->getDateBeginning(). " " .$voucher->getTimeBeginning()."',
            '".$voucher->getDateEnd(). " " .$voucher->getTimeEnd()."',
            ".$voucher->getMinimalPurchase().",
            ".$voucher->getNumberPerUser().",
            ".$is_deleted.",
            'allProducts',
            '".$voucher->getDateBeginning(). " " .$voucher->getTimeBeginning()."',
            NOW()
        );
    </p>";
}

/**
 * ORDERS
 */
$orders = OrderGateway::GetOrdersFromGateway();
foreach($orders as $order){
    $order = (new OrderContainer($order))->getOrder();
    $voucher_id = 'NULL';
    $is_canceled = 0;
    $customer_message = 'NULL';

    if($order->getVoucher() != null) $voucher_id = "'".$order->getVoucher()->getID()."'";
    if($order->getCancel() != null || $order->getCancel() > 0) $is_canceled = 1;
    if($order->getCustomerMessage() != null) $customer_message = "'".str_replace("'", "''", $order->getCustomerMessage())."'";

    if(strpos($order->getCustomer()->getID(), 'offline') !== 0){
        echo "
        <p>
            INSERT INTO orders (id, shippingPrice, productsPrice, paymentMethod, customerMessage, status, isCanceled, user_id, voucher_id, shipping_address_id, billing_address_id, created_at, updated_at)
            VALUES(
                '".$order->getID()."',
                ".$order->getShippingPrice().",
                ".$order->getTotalPrice().",
                ".$order->getPaymentMethod().",
                ".$customer_message.",
                ".$order->getStatus().",
                ".$is_canceled.",
                '".$order->getCustomer()->getID()."',
                ".$voucher_id.",
                '".$order->getShippingAddress()->getID()."',
                '".$order->getBillingAddress()->getID()."',
                '".$order->getDate()."',
                NOW()
            );
        </p>";

        foreach($order->getOrderItems() as $item){
            $item = (new OrderItemContainer($item))->getOrderitem();
            echo "
            <p>
                INSERT INTO order_items (productName, quantity, unitPrice, product_id, order_id, created_at, updated_at)
                VALUES(
                    '".$item->getProduct()->getName()."',
                    ".$item->getQuantity().",
                    ".$item->getUnitPrice().",
                    '".$item->getProduct()->getID2()."',
                    '".$order->getID()."',
                    '".$order->getDate()."',
                    NOW()
                );
            </p>";
        }
    }
}

?>