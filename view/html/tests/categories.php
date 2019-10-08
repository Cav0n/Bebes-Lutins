<?php
// $products = ProductGateway::GetProducts2();
// foreach ($products as $product) {
//     $product = (new ProductContainer($product))->getProduct();
//     $hide = $product->getHide();
//     if ($hide == null) $hide = 0;
//     echo "<p style='margin:1rem 0';>INSERT INTO products (name, description, mainImage, stock, price, isHidden, isDeleted, creationDate, reviewsCount, reviewsStars) VALUES (\"" . $product->getName() . "\",\"" . str_replace('"', "'", strip_tags($product->getDescription())) . "\",\"" . $product->getImage()->getName() . "\"," . $product->getStock() . "," . $product->getPrice() . "," . $hide .",0,NOW(),0,0);</p>";
// }

// echo '/* USERS';

// $users = UserGateway::getAllUsers();
// foreach ($users as $user) {
//     $user = (new UserContainer($user))->getUser();
//     $phone = preg_replace('/\s+/', '', $user->getPhone());
//     if($phone == "Aucunnuméro") $phone = null;
//     if($user->getPrivilege() > 0) $isAdmin = 1; else $isAdmin = 0;
//     echo '<p style="margin:1rem 0";>INSERT INTO users (id, firstname, lastname, email, email_verified_at, phone, password, wantNewsletter, isAdmin, privileges, created_at, updated_at)
//     VALUES (
//         "'. $user->getId() .'",
//         "'. $user->getFirstname() .'",
//         "'. $user->getSurname() .'",
//         "'. $user->getMail() .'",
//         "'. $user->getRegistrationDate() .'",
//         "'. $phone .'",
//         "'. $user->getPassword() .'",
//         "'. $user->isNewsletter() .'",
//         "'. $isAdmin .'",
//         "'. $user->getPrivilege() .'",
//         "'. $user->getRegistrationDate() .'",
//         NOW());</p><BR>';
// }

// echo '*/ /* VOUCHERS';

// $vouchers = VoucherGateway::GetAllVoucher();
// foreach ($vouchers as $voucher){
//     $voucher = (new VoucherContainer($voucher))->getVoucher();
//     echo '<p style="margin:1rem 0";>INSERT INTO vouchers (id, code, description, discountValue, discountType, dateFirst, dateLast)
//         VALUES (
//             "'. $voucher->getId() .'",
//             "'. $voucher->getName() .'",
//             "'. $voucher->getName() .'",
//             "'. $voucher->getDiscount() .'",
//             "'. $voucher->getType() .'",
//             "'. $voucher->getDateBeginning() .'",
//             "'. $voucher->getDateEnd() .'");</p><BR>';
// }

// echo '*/ /* ADDRESSES';

// $addresses = AddressGateway::GetAllAddress();
// foreach ($addresses as $address){
//     $address = (new AddressContainer($address))->getAddress();
//     echo '<p style="margin:1rem 0";>INSERT INTO addresses (id, firstname, lastname, civility, street, zipcode, city, complement, company, userID, created_at, updated_at)
//         VALUES (
//             "'. $address->getId() .'",
//             "'. $address->getFirstname() .'",
//             "'. $address->getSurname() .'",
//             "'. $address->getCivility() .'",
//             "'. $address->getAddressLine() .'",
//             "'. $address->getPostalCode() .'",
//             "'. $address->getCity() .'",
//             "'. $address->getComplement() .'",
//             "'. $address->getCompany() .'",
//             "'. $address->getCustomer()->getId() .'",
//             NOW(),
//             NOW());</p><BR>';
// }

// echo '*/ /* ORDERS';

// $orders = OrderGateway::GetOrdersFromGateway();
// foreach ($orders as $order){
    
//     $order = (new OrderContainer($order))->getOrder();
//     if($order->getVoucher() != null) $voucher_id = '"' . $order->getVoucher()->getID() . '"'; else $voucher_id = 'NULL';
//     if($order->getCancel() == null) $isCanceled = 0; else $isCanceled = 1;
//     if(!(strpos($order->getCustomer()->getID(), "offline") !== false)){
//     echo '<p style="margin:1rem 0";>INSERT INTO orders (id, shippingPrice, productsPrice, paymentMethod, customerMessage, status, isCanceled, user_id, voucher_id, created_at, shipping_address_id, billing_address_id, updated_at)
//         VALUES (
//             "'. $order->getId() .'",
//             "'. $order->getShippingPrice() .'",
//             "'. $order->getTotalPrice() .'",
//             "'. $order->getPaymentMethod() .'",
//             "'. $order->getCustomerMessage() .'",
//             "'. $order->getStatus() .'",
//             "'. $isCanceled .'",
//             "'. $order->getCustomer()->getId() .'",
//             '. $voucher_id .',
//             "'. $order->getDate() .'",
//             "c'. $order->getShippingAddress()->getId() .'",
//             "'. $order->getBillingAddress()->getId() .'",
//             NOW());</p><BR>';
//         }
// }

// echo '*/'

// $thumbnails = ThumbnailsGateway::GetAll();
// $products = ProductGateway::GetProducts2();

// foreach ($thumbnails as $thumbnail) {
//     foreach ($products as $product) {
//         if($thumbnail['product_id'] == $product->getId()){
//             echo 'INSERT INTO image_product (image_id, product_id) VALUES((SELECT id FROM Images where name="'. $thumbnail['image'] .'"), (SELECT id FROM products where name="' . $product->getName() . '"));<BR>';
//         }
//     }
// }

// $categories = CategoryGateway::GetCategories();
// $products = ProductGateway::GetProducts2();

// foreach ($products as $product) {
//     foreach($product->getCategory() as $category){
//         echo "INSERT INTO category_product (category_id, product_id) VALUES( (SELECT id FROM Categories WHERE name='". $category->getName(). "'), (SELECT id FROM Products WHERE name='". $product->getName() ."'));<BR>";
//     }   
// }

$orders = OrderGateway::GetOrdersFromGateway();
$datemax = date_create('2019-09-23');
foreach($orders as $order){
    $date = date_create($order->getDate());
    if($date < $datemax) {
        foreach($order->getOrderItems() as $item){
            echo 'INSERT INTO order_items (productName, quantity, unitPrice, product_id, order_id) VALUES ("'. $item->getProduct()->getName() .'", '. $item->getQuantity() .', '. $item->getUnitPrice() .', (SELECT id FROM Products where name="'. $item->getProduct()->getName() .'"), "'. $order->getID() .'"); <BR>';
        }
    }   
}