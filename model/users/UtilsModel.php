<?php

/**
 * Created by PhpStorm.
 * User: florian
 * Date: 18/11/2018
 * Time: 11:47
 */

class UtilsModel
{
    public static function load_page($page)
    {
        global $view_rep;

        switch ($page){
            case 'accueil':
                require("$view_rep/html/main/index.php");
                break;

            case 'all_categories':
                require("$view_rep/html/category/all_category.php");
                break;

            case 'category':
                require("$view_rep/html/category/index.php");
                break;

            case 'product':
                require("$view_rep/html/product/index.php");
                break;

            case 'password_lost':
                require("$view_rep/html/account/password-lost.php");
                break;

            case 'reset_password':
                require("$view_rep/html/account/password-reset.php");
                break;

            case 'login_page':
                if(isset($_SESSION['connected_user'])) {
                    ?>
                    <script type="text/javascript">
                        document.location.href="https://www.bebes-lutins.fr/espace-client";
                    </script>
                    <?php
                }
                else {
                    require("$view_rep/html/account/login_page.php");
                }
                break;

            case 'registration_page':
                require("$view_rep/html/account/registration_page.php");
                break;

            case 'show_bill':
                require("$view_rep/html/administration/management/order.php");
                break;

            case 'shopping_cart':
                $_SESSION['step_shopping_cart'] = 1;
                require("$view_rep/html/shopping-cart/index.php");
                break;

            case 'connection_while_ordering':
                $_SESSION['step_shopping_cart'] = 2;
                require("$view_rep/html/shopping-cart/connect-while-ordering.php");
                break;

            case 'delivery':
                $_SESSION['step_shopping_cart'] = 2;
                require("$view_rep/html/shopping-cart/order-delivery.php");
                break;

            case 'payment':
                $_SESSION['step_shopping_cart'] = 3;
                require("$view_rep/html/shopping-cart/order-payment.php");
                break;

            case 'payment-cheque':
                $_SESSION['step_shopping_cart'] = 3;
                require("$view_rep/html/shopping-cart/order-payment-cheque.php");
                break;

            case 'order_cancel':
                require("$view_rep/html/shopping-cart/order-cancel.php");
                break;

            case 'thanks':
                $_SESSION['step_shopping_cart'] = 4;
                require("$view_rep/html/shopping-cart/thanks.php");
                break;

            case 'birthlist':
                require("$view_rep/html/account/birthlist/visitor/index.php");
                break;

            case 'product_test':
                require("$view_rep/html/tests/product-page.php");
                break;

            case 'error':
                require("$view_rep/html/main/error.php");
                break;

            default:
                $_SESSION['error_message'] = "La page que vous cherchez n'existe pas, ou le lien que vous avez suivis est rompu...";
                require("$view_rep/html/main/error.php");
                break;
        }
    }

    public static function load_static_page($page){
        global $view_rep;

        switch ($page){
            case 'contact':
                require("$view_rep/html/statics/contact.php");
                break;

            case 'shipping_infos':
                require("$view_rep/html/statics/shipping_infos.php");
                break;

            case 'payment_infos':
                require("$view_rep/html/statics/payment_infos.php");
                break;

            case 'return_refund_infos':
                require("$view_rep/html/statics/return_refund_infos.php");
                break;

            case 'legal_notices_infos':
                require("$view_rep/html/statics/legal_notices_infos.php");
                break;

            case 'terms_of_sales_infos':
                require("$view_rep/html/statics/terms_of_sales_infos.php");
                break;

            case 'presentation':
                require("$view_rep/html/statics/presentation.php");
                break;

            case 'guide_and_tips':
                require("$view_rep/html/statics/guide_and_tips.php");
                break;

            case 'why-washable-nappies':
                require("$view_rep/html/statics/why-washable-nappies.php");
                break;

            case 'preserve-washable-nappies':
                require("$view_rep/html/statics/preserve-washable-nappies.php");
                break;

            case 'manual-washable-nappies':
                require("$view_rep/html/statics/manual-washable-nappies.php");
                break;

            case 'how-to-equip':
                require("$view_rep/html/statics/how-to-equip.php");
                break;

            case 'retailers':
                require("$view_rep/html/statics/retailers.php");
                break;
        }
    }

    public static function order_status_to_string(int $state){
        switch ($state){
            case '0':
                return "En attente de paiement";
                break;

            case '1':
                return "En cours de traitement";
                break;

            case '2':
                return "En cours de livraison";
                break;

            case '3':
                return "Livrée";
                break;

            case '-1':
                return "Annulée";
                break;
        }
    }

    public static function load_head()
    {
        global $view_rep;

        require("$view_rep/html/components/head.php");
    }

    public static function load_header(){
        global $view_rep;

        require("$view_rep/html/components/header.php");
    }

    public static function load_menu_mobile(){
        global $view_rep;
        require("$view_rep/html/components/menu-mobile.php");
    }

    public static function load_footer(){
        global $view_rep;

        require("$view_rep/html/components/footer.php");
    }

    public static function load_categories_display(){
        global $view_rep;
        require("$view_rep/html/components/categories_display.php");
    }

    public static function load_products_display(){
        global $view_rep;
        require("$view_rep/html/components/products_display.php");
    }

    public static function load_swiper(){
        global $view_rep;
        require("$view_rep/html/components/swiper.php");
    }

    public static function load_category_swiper(){
        global $view_rep;
        require("$view_rep/html/components/category_swiper.php");
    }

    public static function load_certifications(){
        global $view_rep;
        require("$view_rep/html/components/certifications.php");
    }

    public static function load_image_product($image) : String{
        global $view_rep;
        return"<img src='$view_rep/assets/images/products/$image'>";
    }

    public static function load_shopping_cart_stepper(){
        global $view_rep;
        require("$view_rep/html/components/shopping_cart_stepper.php");
    }

    public static function load_thanks(){
        unset($_SESSION['shopping_cart']);
        unset($_SESSION['order']);

        $_SESSION['shopping_cart'] = serialize(new ShoppingCart("local", 0, array()));
        ?>
        <script type="text/javascript">
            document.location.href="https://www.bebes-lutins.fr/merci"
        </script>
        <?php
    }

    public static function show_all_products(){
        $_SESSION['limit_product_display'] = -1;
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/"?>';
        </script>
        <?php
    }

    public static function show_less_products(){
        $_SESSION['limit_product_display'] = 8;
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/"?>';
        </script>
        <?php
    }

    public static function send_password_lost_link(String $mail){
        $verification_key = bin2hex(openssl_random_pseudo_bytes(10, $cstrong)); //Key for email verification
        if(UserGateway::UpdateVerificationKey($mail, $verification_key)){
            $message = "Bonjour, vous avez demandé un changement de mot de passe sur notre site, pour ce faire veuillez cliquer sur le lien suivant : <a href='https://www.bebes-lutins.fr/reinitialisation-mot-de-passe-$verification_key/$mail'>Je souhaite reinitialiser mon mot de passe.</a>";
            self::EnvoieNoReply($mail, "Reinitialisation de votre mot de passe", $message);

            $_SESSION['password_lost_message_ok'] = "<p class='password-lost-message-ok'>Un email vous a été envoyé. Veuillez vérifier dans votre dossier de spam.</p>";

        } else {
            $_SESSION['password_lost_message_error'] = "<p class='password-lost-message-error horizontal centered'>Aucun compte n'est lié à cette adresse mail.</p>";
        }
        ?>
        <script type="text/javascript">
            document.location.href = "https://www.bebes-lutins.fr/mot-de-passe-perdu";
        </script>
        <?php
    }

    public static function reset_password(string $mail, string $key, string $new_password){
        $hashed_password = password_hash($new_password,PASSWORD_DEFAULT); //Password encryption

        UserGateway::UpdatePasswordWithVerificationKey($mail, $key, $hashed_password);

        ?>
        <script type="text/javascript">
            document.location.href = "https://www.bebes-lutins.fr/espace-client/connexion";
        </script>
        <?php
    }

    public static function add_review(String $product_id, String $customer_id,String $customer_name, int $mark, String $text)
    {
        $id = uniqid("review-");
        try {
            if(!BannedWords::StringContainsBannedWords($text)){
                ReviewGateway::AddReviewForProduct($id, $product_id, $customer_id, $customer_name, $mark, $text, false);
                UtilsModel::EnvoieMail("contact@bebes-lutins.fr", "Notification Commentaire", "no-reply@bebes-lutins.fr", "Nouveau commentaire !", "Il y a un nouveau commentaire sur le produit https://www.bebes-lutins.fr/produit/".$product_id);
            } else {
                ReviewGateway::AddReviewForProduct($id, $product_id, $customer_id, $customer_name, $mark, $text, true);
                UtilsModel::EnvoieMail("contact@bebes-lutins.fr", "Notification Commentaire", "no-reply@bebes-lutins.fr", "Commentaire a vérifier !", "Il y a un nouveau commentaire a vérifier !");
            }
        } catch (PDOException $e) {
            $_SESSION['review-message'] = "Une erreur est survenue, veuillez recommecencer s'il vous plaît." . $e->getMessage();
        }
        if (!isset($_SESSION['review-message']))
            $_SESSION['review-message'] = "Votre avis a bien été envoyé, il devrait être publié sous peu.";

        ?>
        <script type="text/javascript">
            document.location.href = "https://www.bebes-lutins.fr/produit/<?php echo $product_id?>";
        </script>
        <?php
    }

    public static function send_message(String $name, String $mail, String $subject, String $message){
        if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
            $_SESSION['contact-message'] = "<p style='color: #b41620; text-align: center;'>Veuillez vérifier que vous n'êtes pas un robot grâce au Captcha.</p>";
        } else {
            $secretKey = "6Ldj9p4UAAAAAO-lFqcTg5irY1504Y_NCU2S01js";
            $ip = $_SERVER['REMOTE_ADDR'];
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);
            // should return JSON with success as true
            if ($responseKeys["success"]) {
                if(!BannedWords::StringContainsBannedWords($message)) {
                    UtilsModel::EnvoieMail("contact@bebes-lutins.fr", $name, $mail, $subject, "$name ($mail) vous a envoyé un message à partir du site Bébés Lutins : <BR>------<BR><BR><u>$subject</u><BR>$message");
                    UtilsModel::EnvoieNoReply($mail, "Message recu !", "Bonjour $name, nous vous envoyons ce mail pour vous confirmer que nous avons bien recu votre message : $subject 
            $message 
        Ceci est une réponse automatique, veuillez ne pas y répondre. 
        Cordialement,
        l'équipe Bébés Lutins.");
                    $_SESSION['contact-message'] = "<p style='color: #33b40f; text-align: center;'>Message envoyé !</p>";
                } else{
                    $_SESSION['contact-message'] = "<p style='color: #b41620; text-align: center;'>Vous avez entré un terme interdit.</p>";
                }
            }
        }

        ?>
        <script type="text/javascript">
            document.location.href="https://www.bebes-lutins.fr/contact";
        </script>
        <?php
    }

    public static function shopping_cart_add_product(Product $product, $quantity){
        $shopping_cart = unserialize($_SESSION['shopping_cart']);
        $shopping_cart->addShoppingCartItems(new ShoppingCartItem(uniqid("element-"), $product, $quantity, $product->getPrice()));
        $_SESSION['shopping_cart'] = serialize($shopping_cart);
        unset($_SESSION['product']);
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/panier"?>';
        </script>
        <?php
    }

    public static function shopping_cart_add_voucher(String $voucher_name){
        $shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
        $voucher = VoucherGateway::SearchVoucherByName(strtoupper($voucher_name));

        if($_POST['message'] != null){
            $shopping_cart->setMessage($_POST['message']);
        }

        if ($voucher != null){
            if(!$voucher->isExpire()){
                if($shopping_cart->getTotalPrice() >= $voucher->getMinimalPurchase()){
                    $shopping_cart->setVoucher($voucher);
                    $_SESSION['shopping_cart'] = serialize($shopping_cart);
                    $_SESSION['voucher_message'] = "<p style='color:green;font-size: 0.9em;'>Le code a bien été ajouté au panier.</p>";
                } else $_SESSION['voucher_message'] = "<p style='color:red;font-size: 0.9em;'>Vous devez avoir un minimum d'achat de " . UtilsModel::FloatToPrice($voucher->getMinimalPurchase()). ".</p>";
            } else $_SESSION['voucher_message'] = "<p style='color:red;font-size: 0.9em;'>Ce code de réduction n'est plus valable.</p>";
        } else $_SESSION['voucher_message'] = "<p style='color:red;font-size: 0.9em;'>Ce code de réduction n'existe pas.</p>";
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/panier"?>';
        </script>
        <?php
    }

    public static function shopping_cart_add_message(String $message){
        $shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
        $shopping_cart->setMessage($message);
        $_SESSION['shopping_cart'] = serialize($shopping_cart);

        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/panier"?>';
        </script>
        <?php
    }

    public static function shopping_cart_delete_product(String $id){
        $shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
        $item_list = $shopping_cart->getShoppingCartItems();
        $i = 0;
        foreach ($item_list as $item){
            $item = (new ShoppingCartItemContainer($item))->getShoppingCartItem();
            if($item->getId() == $id){
                $shopping_cart->setTotalPrice($shopping_cart->getTotalPrice() - ($item->getPrice() * $item->getQuantity()));
                array_splice($item_list, $i, 1);
                $shopping_cart->setShoppingCartItems($item_list);
                break;
            }
            $i++;
        }

        $_SESSION['shopping_cart'] = serialize($shopping_cart);
        self::load_page('shopping_cart');
    }

    public static function shopping_cart_change_quantity(String $id, int $new_quantity){
        $shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
        $item_list = $shopping_cart->getShoppingCartItems();
        $i = 0;
        foreach ($item_list as $item){
            $item = (new ShoppingCartItemContainer($item))->getShoppingCartItem();
            if($item->getId() == $id){
                $shopping_cart->setTotalPrice(($shopping_cart->getTotalPrice()  - ($item->getPrice() * $item->getQuantity())) + ($item->getPrice() * $new_quantity));
                $item->setQuantity($new_quantity);
                break;
            }
            $i++;
        }

        $_SESSION['shopping_cart'] = serialize($shopping_cart);
    }

    public static function birthlist_item_change_quantity($item_id, $quantity)
    {
        BirthlistGateway::UpdateQuantityOfItem($item_id, $quantity);
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/espace-client/liste-de-naissance"?>';
        </script>
        <?php
    }

    public static function load_delivery(){
        $_SESSION['step_shopping_cart'] = 2;
        if(isset($_SESSION['connected_user'])){
            $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
            $user_id = $user->getId();

            $shipping_price = UtilsGateway::getShippingPrice();
            $free_shipping_price = UtilsGateway::getFreeShippingPrice();

            $shopping_cart = (new ShoppingCartContainer(unserialize($_SESSION['shopping_cart'])))->getShoppingCart();
            $total_price = $shopping_cart->getTotalPrice();
            if($shopping_cart->getTotalPrice() >= $free_shipping_price) $shipping_price = 0;

            $order = new Order(uniqid( "$user_id-"), $user, new Address("", $user, "", "", "", "", "",0, "", ""), new Address("", $user, "", "", "", "", "", 0, "", ""), date('Y-m-d'), 0, $shipping_price, $total_price, 0, null, null);

            if($shopping_cart->getMessage() != null)
            {
                $order->setCustomerMessage($shopping_cart->getMessage());
            }
            if($_POST['message'] != null){
                $shopping_cart->setMessage($_POST['message']);
                $order->setCustomerMessage($_POST['message']);
            }

            foreach ($shopping_cart->getShoppingCartItems() as $item){
                $item = (new ShoppingCartItemContainer($item))->getShoppingCartItem();
                $order->addOrderItem(new OrderItem(uniqid($item->getId() . '-'), $item->getProduct(), $item->getQuantity(), $item->getPrice()));
            }

            if($shopping_cart->getVoucher() != null) $order->setVoucher($shopping_cart->getVoucher());

            $_SESSION['order'] = serialize($order);

            $_SESSION['shopping_cart'] = serialize($shopping_cart);

            VisitorModel::load_page('shopping_cart_delivery');
        }
        else{
            $_SESSION['redirect_url'] = 'https://www.bebes-lutins.fr/panier/livraison';
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/panier/connexion"?>';
            </script>
            <?php
        }
    }

    public static function load_payment($address_type){
        $_SESSION['step_shopping_cart'] = 3;
        if($address_type == null){
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/panier"?>';
            </script>
            <?php
        }
        try {

            if(isset($_SESSION['connected_user'])) $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
            else $user = null;

            $order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();
            $id_uniq = uniqid();
            $billing_id = $id_uniq . "-billing";
            $shipping_id = $id_uniq . '-shipping';

            if($user==null){
                $customer_id = "offline-" . $id_uniq;
                $user_offline = new UserConnected($customer_id, $_POST['surname_billing'], $_POST['firstname_billing'], $_POST['mail'], $_POST['phone'], 0, date('Y-d-m'), true);
            } else $customer_id = $user->getId();

            switch ($address_type) {
                case 'new':
                    if($user == null){
                        $address_billing = new Address($shipping_id, $user_offline, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'],$_POST['street_billing'],$_POST['city_billing'],$_POST['zip_code_billing'],$_POST['complement_billing'],$_POST['company_billing']);
                        if(isset($_POST['same_shipping_address']) && $_POST['same_shipping_address'] == 'yes'){
                            $address_shipping = new Address($billing_id, $user_offline, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'],$_POST['street_billing'],$_POST['city_billing'],$_POST['zip_code_billing'],$_POST['complement_billing'],$_POST['company_billing']);
                        } else {
                            $address_shipping = new Address($billing_id, $user_offline, $_POST['civility_shipping'], $_POST['surname_shipping'], $_POST['firstname_shipping'],$_POST['street_shipping'],$_POST['city_shipping'],$_POST['zip_code_shipping'],$_POST['complement_shipping'],$_POST['company_shipping']);
                        }
                    }
                    else{
                        $address_billing = new Address($shipping_id, $user, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'],$_POST['street_billing'],$_POST['city_billing'],$_POST['zip_code_billing'],$_POST['complement_billing'],$_POST['company_billing']);
                        if(isset($_POST['same_shipping_address']) && $_POST['same_shipping_address'] == 'yes'){
                            $address_shipping = new Address($billing_id, $user, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'],$_POST['street_billing'],$_POST['city_billing'],$_POST['zip_code_billing'],$_POST['complement_billing'],$_POST['company_billing']);
                        } else {
                            $address_shipping = new Address($billing_id, $user, $_POST['civility_shipping'], $_POST['surname_shipping'], $_POST['firstname_shipping'],$_POST['street_shipping'],$_POST['city_shipping'],$_POST['zip_code_shipping'],$_POST['complement_shipping'],$_POST['company_shipping']);
                        }
                    }

                    $order->setBillingAddress($address_billing);
                    $order->setShippingAddress($address_shipping);

                    $order->getCustomer()->setId($customer_id);
                    $order->getCustomer()->setSurname($address_billing->getSurname());
                    $order->getCustomer()->setFirstname($address_billing->getFirstname());

                    if($user_offline!=null) {
                        $order->getCustomer()->setMail($user_offline->getMail());
                        $order->getCustomer()->setPhone($user_offline->getPhone());
                    }
                    $_SESSION['order'] = serialize($order);

                    self::load_page("payment");
                    break;

                case 'selected':
                    $address_billing_id = $_POST['billing_address_selected_id'];
                    $address_shipping_id = $_POST['shipping_address_selected_id'];

                    $address_list = AddressGateway::GetBillingAndShippingAddress($address_billing_id, $address_shipping_id, $user);

                    $order->setBillingAddress($address_list['billing']);
                    $order->setShippingAddress($address_list['shipping']);

                    $order->setCustomer($user);

                    $_SESSION['order'] = serialize($order);

                    self::load_page("payment");
                    break;

                case 'withdrawal-shop':
                    $order->setShippingPrice(0);
                    if($user==null) {
                        $user_offline = new UserConnected($customer_id, $_POST['surname_billing'], $_POST['firstname_billing'], $_POST['mail'], $_POST['phone'], 0, date('Y-d-m'), true);
                        $billing_address = new Address($billing_id, $user_offline, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'], $_POST['street_billing'], $_POST['city_billing'], $_POST['zip_code_billing'], $_POST['complement_billing'], $_POST['company_billing']);
                        $shipping_address = new Address("withdrawal-shop-" . $id_uniq, $user_offline, $billing_address->getCivility(), $billing_address->getSurname(), $billing_address->getFirstname(), $billing_address->getAddressLine(), $billing_address->getCity(), $billing_address->getPostalCode(), $billing_address->getComplement(), $billing_address->getCompany());

                        $order->setCustomer($user_offline);
                        $order->setBillingAddress($billing_address);
                        $order->setShippingAddress($shipping_address);

                        $_SESSION['order'] = serialize($order);

                        self::load_page("payment");
                        break;
                    }
                    else{
                        $billing_address = new Address($billing_id, $user, $_POST['civility_billing'], $_POST['surname_billing'], $_POST['firstname_billing'], $_POST['street_billing'], $_POST['city_billing'], $_POST['zip_code_billing'], $_POST['complement_billing'], $_POST['company_billing']);
                        $shipping_address = new Address("withdrawal-shop-" . $id_uniq, $user, $billing_address->getCivility(), $billing_address->getSurname(), $billing_address->getFirstname(), $billing_address->getAddressLine(), $billing_address->getCity(), $billing_address->getPostalCode(), $billing_address->getComplement(), $billing_address->getCompany());

                        $order->setCustomer($user);
                        $order->setBillingAddress($billing_address);
                        $order->setShippingAddress($shipping_address);

                        $_SESSION['order'] = serialize($order);
                        self::load_page("payment");
                        break;
                    }


                    break;

                default:
                    throw new Exception('Un problème est survenu dans la prise en charge de votre commande, nous en sommes désolé.');
                    break;
            }
        } catch (Exception $e){
            echo $e;
        }
    }

    public static function init_pay($payment_method){
        if($payment_method == null){
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/panier"?>';
            </script>
            <?php
        }
        else {
            $order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();
            switch ($payment_method) {
                case 1 : //Carte bancaire
                    self::init_creditcard_payment($order);
                    break;

                case 2 : //Chèque bancaire
                    self::init_bankcheque_payment($order);
                    break;

                default: //Erreur
                    break;
            }
        }
    }

    public static function init_creditcard_payment(Order $order){
        $order->setPaymentMethod(1);
        $_SESSION['order'] = serialize($order);
        self::creditcard_payment($order);
    }

    public static function creditcard_payment(Order $order){
        if(isset($_SESSION['connected_user'])){
            $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
            $user->addOrder($order);
            $_SESSION['connected_user'] = serialize($user);
        }
        OrderGateway::CreateNewInDB($order);
        $price = $order->getPriceAfterDiscount();

        $array = array();
        require("payment/lib/paylineSDK.php");
        require("payment/lib/CONFIG.php");
        $order_id = $order->getId();

        $payline = new paylineSDK(MERCHANT_ID, ACCESS_KEY, PROXY_HOST, PROXY_PORT, PROXY_LOGIN, PROXY_PASSWORD, ENVIRONMENT);
        $payline->returnURL = RETURN_URL."&idcommande=". $order_id;
        $payline->cancelURL = CANCEL_URL . "&idcommande=". $order_id;
        $payline->notificationURL = NOTIFICATION_URL."&idcommande=". $order_id;
        $payline->customPaymentPageCode = CUSTOM_PAYMENT_PAGE_CODE;

//VERSION
        $array['version'] = WS_VERSION;

// PAYMENT
        $array['payment']['amount'] = $price * 100;
        $array['payment']['currency'] = 978;
        $array['payment']['action'] = PAYMENT_ACTION;
        $array['payment']['mode'] = PAYMENT_MODE;

// ORDER
        $array['order']['ref'] = $order_id;
        $array['order']['amount'] = $price * 100;
        $array['order']['currency'] = 978;

// CONTRACT NUMBERS
        $array['payment']['contractNumber'] = CONTRACT_NUMBER;
        $contracts = explode(";",CONTRACT_NUMBER_LIST);
        $array['contracts'] = $contracts;
        $secondContracts = explode(";",SECOND_CONTRACT_NUMBER_LIST);
        $array['secondContracts'] = $secondContracts;

        //Insertion dans les commandes (bdd)

        //s$elements = unserialize($_SESSION['elements']);
        /*foreach ($elements as $e){
            $prix = (ProduitGateway::RechercherProduitFromDB($e['IDProduit'])->GetPrix());
            CommandeGateway::AjouterElement(uniqid(""), $idcommande, $e['IDProduit'], $e['Quantite'], $prix);
            ProduitGateway::UpdateStock($e['IDProduit'], $e['Quantite']);
        }
        CommandeGateway::Ajouter($idcommande, unserialize($_SESSION['user'])->GetID(), $_SESSION['idadresse'], date("Y-m-d"), $_SESSION['prix'], 1, $coupon, null);*/
// EXECUTE
        $response = $payline->doWebPayment($array);


        if(isset($response) && $response['result']['code'] == '00000'){
            if( !headers_sent() ){
                header("location:".$response['redirectURL']);
            }else{
                ?>
                <script type="text/javascript">
                    document.location.href="<?php echo $response['redirectURL'];?>";
                </script>
                Vous allez être rediriger vers la <a href="<?php echo $response['redirectURL'] ?>">page de paiement</a>.
                <?php
            }
            die();
        }elseif(isset($response)) {
            echo "Une erreur s'est produite : ".$response['result']['code']. ' '.$response['result']['longMessage']." 
            <BR>Vous pouvez nous contacter à l'adresse suivante : contact@bebes-lutins.fr";
        }

    }

    public static function order_cancel(String $order_id){
        $order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();

        OrderGateway::UpdateOrderStatusWithOrderID($order->getId(), -1, null);
        $order->setStatus(-1);
        $_SESSION['order'] = serialize($order);

        ?>
        <script type="text/javascript">
            document.location.href="https://www.bebes-lutins.fr/panier";
        </script>
        <?php
    }

    public static function init_bankcheque_payment(Order $order){
        $order->setPaymentMethod(2);
        $_SESSION['order'] = serialize($order);
        self::load_page('payment-cheque');
    }

    public static function end_order_cheque(){
        if($_SESSION['order'] == null){
            self::load_page('thanks');
        }
        else {
            $order = (new OrderContainer(unserialize($_SESSION['order'])))->getOrder();
            try {
                OrderGateway::CreateNewInDB($order);
            } catch (PDOException $e){
                echo "OH NO : " . $e->getMessage();
            }
            $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
            $user->addFirstOrder($order);

            if($user->getAddressList())

            $user->addAddress($order->getBillingAddress());
            $user->addAddress($order->getShippingAddress());

            $_SESSION['connected_user'] = serialize($user);

            self::OrderNotification($order->getId());

            unset($_SESSION['shopping_cart']);
            unset($_SESSION['order']);

            $_SESSION['shopping_cart'] = serialize(new ShoppingCart("local", 0, array()));

            self::load_page('thanks');
        }
    }

    public static function OrderNotification(String $order_id){
        $order = OrderGateway::GetOrderFromDBByID($order_id);

        if($order->getCancel() == false){
            $customer = $order->getCustomer();
            $order_items = $order->getOrderItems();
            $order_price = str_replace('EUR', '€', money_format("%.2i", $order->getTotalPrice() + $order->getShippingPrice()));
            $order_shipping_price = str_replace('EUR', '€', money_format("%.2i", $order->getShippingPrice()));
            $order_voucher = $order->getVoucher();
            $order_payment_method = $order->getPaymentMethodString();
            $customer_surname = $customer->getSurname();
            $customer_firstname = $customer->getFirstname();

            if($order_voucher != null){
                if($order_voucher->getType() == 3) {
                    $order_shipping_price = str_replace('EUR', '€', money_format("%.2i", 0));
                    $order_price = str_replace('EUR', '€', money_format("%.2i", $order->getTotalPrice()));
                }
                else {
                    $order_price = str_replace('EUR', '€', money_format("%.2i", $order->getPriceAfterDiscount()));
                }
            }

            // Mail pour l'administration :
            $subject = "Une commande à été passée";
            $administration_message = "Une commande par <u>$order_payment_method</u> de <b>$customer_firstname $customer_surname</b> d'un montant de <b>$order_price (Frais de port : $order_shipping_price)</b> a été effectué !";

            if($order->getPaymentMethod() == 1){
                OrderGateway::UpdateOrderStatusWithOrderID($order->getId(), 1, null);
            }
            UtilsModel::EnvoieNoReply("contact@bebes-lutins.fr", $subject, $administration_message);

            // Mail pour le client :
            $customer_mail = $customer->getMail();
            $subject = "Merci pour votre commande!";
            $customer_message = "$customer_firstname $customer_surname,
            Bébés Lutins vous remercie pour cette commande de $order_price.
            Notre équipe la traitera dans les meilleurs délais.
            Vous pouvez suivre à tout moment l'avancement du traitement de votre commande dans votre espace client.
            
            Cordialement,
            Toute l'équipe Bébés Lutins.";

            UtilsModel::EnvoieNoReply($customer_mail, $subject, $customer_message);
        }
    }

    // Mails

    public static function EnvoieMail(String $destinataire, String $name, String $expediteur, String $sujet_mail, String $message){
        require 'vendor/autoload.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try{
            $mail->CharSet = 'UTF-8';

            // SET SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = 0;

            // SET SERVER
            $mail->Host = "smtp.1and1.com";
            $mail->Port = 25;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Username = 'no-reply@bebes-lutins.fr';
            $mail->Password = 'Acty-63300';

            // SET RECIPIENTS
            $mail->setFrom($expediteur, $name);
            $mail->addAddress("$destinataire");

            // SET MESSAGE
            $mail->isHTML(true);
            $mail->Subject = "$sujet_mail";
            $mail->Body = "$message";
            $mail->AltBody = "$message";

            $mail->send();
        } catch (Exception $e){
            echo $e->getMessage();
        } catch (\PHPMailer\PHPMailer\Exception $e){
            echo $e->getMessage();
        }
    }

    public static function EnvoieNoReply(String $destinataire, String $sujet_mail, $message){
        require 'vendor/autoload.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try{
            $mail->CharSet = 'UTF-8';

            // SET SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = 0;

            // SET SERVER
            $mail->Host = "smtp.1and1.com";
            $mail->Port = 25;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Username = 'no-reply@bebes-lutins.fr';
            $mail->Password = 'Acty-63300';

            // SET RECIPIENTS
            $mail->setFrom('no-reply@bebes-lutins.fr', 'Bébés Lutins');
            $mail->addAddress("$destinataire");

            // SET MESSAGE
            $mail->isHTML(true);
            $mail->Subject = "$sujet_mail";
            $mail->Body = "$message";
            $mail->AltBody = "$message";

            $mail->send();
        } catch (Exception $e){
            echo $e->getMessage();
        } catch (\PHPMailer\PHPMailer\Exception $e){
            echo $e->getMessage();
        }
    }

    public static function TestMail(){
        require 'vendor/autoload.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try{
            $mail->CharSet = 'UTF-8';

            // SET SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = 0;

            // CONFIG SERVER
            $mail->Host = "smtp.1and1.com";
            $mail->Port = 25;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Username = 'no-reply@bebes-lutins.fr';
            $mail->Password = 'Acty-63300';

            // SET RECIPIENTS
            $mail->setFrom('no-reply@bebes-lutins.fr', 'Bébés Lutins');
            $mail->addAddress('cav0n@hotmail.fr');

            // SET MESSAGE
            $mail->isHTML(true);
            $mail->Subject = "Dernier test";
            $mail->Body = "Bien joué le <b>coinks</b> !";
            $mail->AltBody = "Bien joué.";

            // SEND
            $mail->send();
            echo "OK";
        } catch (Exception $e){
            echo $e->getMessage();
        } catch (\PHPMailer\PHPMailer\Exception $e){
            echo $e->getMessage();
        }
    }

    public static function NotificationMessage(String $destinataire, String $sujet_mail, $message, $nom, $mail_expediteur){
        $mail = $destinataire; // Déclaration de l'adresse de destination.
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
        //=====Déclaration des messages au format texte et au format HTML.
        $message_txt = $message;
        $message_html = "<html><head></head><body>$message</body></html>";
        //==========

        //=====Lecture et mise en forme de la pièce jointe.
        //$fichier   = fopen("image.jpg", "r");
        //$attachement = fread($fichier, filesize("image.jpg"));
        //$attachement = chunk_split(base64_encode($attachement));
        //fclose($fichier);
        //==========

        //=====Création de la boundary.
        $boundary = "-----=".md5(rand());
        $boundary_alt = "-----=".md5(rand());
        //==========

        //=====Définition du sujet.
        $sujet = $sujet_mail;
        //=========

        //=====Création du header de l'e-mail.
        $header = "From: \"$nom\"<$mail_expediteur>".$passage_ligne;
        $header.= "Reply-to: <$mail_expediteur>".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        $message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        //==========

        $message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

        //=====Ajout du message au format HTML.
        $message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========

        //=====On ferme la boundary alternative.
        $message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
        //==========



        $message.= $passage_ligne."--".$boundary.$passage_ligne;

        //=====Ajout de la pièce jointe.
        //$message.= "Content-Type: image/jpeg; name=\"image.jpg\"".$passage_ligne;
        //$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
        //$message.= "Content-Disposition: attachment; filename=\"image.jpg\"".$passage_ligne;
        //$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
        //$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========
        //=====Envoi de l'e-mail.
        mail($mail,$sujet,$message,$header);

        //==========
    }

    public static function FloatToPrice(float $number){
       return str_replace('EUR', '€', money_format("%.2i", $number));

    }

    public static function StatusToColor(int $status){
        switch ($status){
            case 0 :
                $color = "yellow";
                break;

            case 1 :
                $color = "blue";
                break;

            case 2 :
                $color = "#ee8900";
                break;

            case 3 :
                $color = "green";
                break;

            case -1 :
                $color = "red";
                break;

            default :
                $color = "white";
                break;
        }
        return $color;
    }

    public static function CalculateTurnover(String $beginning_date, String $end_date){
        $shipping_price_only = UtilsGateway::calculateShippingPrice($beginning_date, $end_date);
        $turnover_orders = UtilsGateway::calculateTurnover($beginning_date, $end_date);
        $total = $shipping_price_only + $turnover_orders;
        echo "Total des frais de ports : " . $shipping_price_only . "€ <BR>";
        echo "Total des commandes : " . $turnover_orders . "€ <BR>";
        echo "Total des commandes + frais de ports : " . $total . "€ <BR>";
    }

    public static function replace_accent($string){
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        $str = strtr( $string, $unwanted_array );

        $str = preg_replace('/\s+/', '', $str);

        return $str;
    }
}