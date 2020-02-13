<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:15
 */

class ConnectedModel
{
    public static function load_page(String $page)
    {
        try{
            if(isset($_SESSION['connected_user'])) {
                global $view_rep;
                switch ($page) {
                    case 'customer-area':
                        require("$view_rep/html/account/index.php");
                        break;

                    case 'customer-orders':
                        require("$view_rep/html/account/account-orders.php");
                        break;

                    case 'customer-address':
                        require("$view_rep/html/account/account-address.php");
                        break;

                    case 'customer-whishlist':
                        require("$view_rep/html/account/wishlist/main.php");
                        break;

                    case 'customer-birthlist':
                        require("$view_rep/html/account/birthlist/owner/index.php");
                        break;

                    case 'shopping_cart_delivery':
                        require("$view_rep/html/shopping-cart/order-delivery.php");
                        break;

                    case 'orders':
                        require("$view_rep/html/account/orders.php");
                        break;

                    case 'password':
                        require("$view_rep/html/account/new-password.php");
                        break;

                    case 'birthlist_billing':
                        require("$view_rep/html/account/birthlist/visitor/address.php");
                        break;

                    case 'birthlist_payment':
                        require("$view_rep/html/account/birthlist/visitor/payment.php");
                        break;

                    case 'birthlist_cheque_payment':
                        require("$view_rep/html/account/birthlist/visitor/cheque_payment.php");
                        break;

                    case 'thanks_birthlist_payment':
                        require("$view_rep/html/account/birthlist/visitor/thanks.php");
                        break;

                    default:
                        throw new Exception("La page que vous cherchez n'existe pas, ou le lien que vous avez suivis est rompu...");
                        break;
                }
            } else {
                $_SESSION['redirect_url'] = 'https://www.bebes-lutins.fr/'.$_SERVER['REQUEST_URI'];
                ?>
                <script type="text/javascript">
                    document.location.href='https://www.bebes-lutins.fr/espace-client/connexion';
                </script>
                <?php
            }
        } catch(Exception $e){
            $_POST['message'] = "<p id='error-message'>".$e->getMessage()."</p>";
            UtilsModel::load_page("connection_page");
        }
    }

    public static function logout(){
        try{
            if(isset($_SESSION['connected_user'])) {
                unset($_SESSION['connected_user']);
                unset($_SESSION['shopping_cart']);
                ?>
                <script type="text/javascript">
                    document.location.href='https://www.bebes-lutins.fr';
                </script>
                <?php
            } else throw new Exception("Vous devez être connecté pour accéder à cette page.");
        } catch (Exception $e){
            $_POST['message'] = "<p id='error-message'>".$e->getMessage()."</p>";
            UtilsModel::load_page("connection_page");
        }
    }

    public static function add_product_to_wishlist($wishlist_id, $product_id){
        $result_code = WishListGateway::AddItemToWishlist($wishlist_id, $product_id);
        if($result_code < 0) {
            $_SESSION['error-message'] = '<p>Le produit est déjà dans votre liste d\'envie.</p>';

            ?>
            <script type="text/javascript">
                document.location.href='https://www.bebes-lutins.fr/produit/' + <?php echo $product_id; ?>;
            </script>
            <?php

        } else {
            ?>
            <script type="text/javascript">
                document.location.href='https://www.bebes-lutins.fr/espace-client/liste-envie';
            </script>
            <?php
        }
    }

    public static function delete_item_from_wishlist($item_id){
        try{ 
            WishListGateway::DeleteItemFromWishlist($item_id);
        } catch(PDOException $e){
            echo $e;
        }

        ?>
            <script type="text/javascript">
                document.location.href='https://www.bebes-lutins.fr/espace-client/liste-envie';
            </script>
            <?php
    }

    public static function change_informations(String $id, String $surname, String $firstname, String $phone, String $mail){
        try{
            if(isset($_SESSION['connected_user'])){
                UserGateway::change_informations($id, $surname, $firstname, $phone, $mail);
                VisitorModel::login($mail, $_SESSION['password']);
                $_POST['message'] = "<p id='infos-message'>Vos informations ont bien été modifiées.</p>";
                ConnectedModel::load_page('customer-area');
            } else throw new Exception("Vous devez être connecté pour accéder à cette page.");
        } catch(PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        } catch(Exception $e){
            $_POST['message'] = "<p id='error-message'>".$e->getMessage()."</p>";
            UtilsModel::load_page("login_page");
        }
    }

    public static function change_password(String $id, String $old_password, String $new_password){
        try{
            if(isset($_SESSION['connected_user'])){
                $hashed_new_password = password_hash($new_password,PASSWORD_DEFAULT); //Password encryption

                UserGateway::change_password($id, $old_password, $hashed_new_password);
                ConnectedModel::load_page('customer-area');
            } else throw new Exception("Vous devez être connecté pour accéder à cette page.");
        } catch(PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        } catch(Exception $e){
            $_POST['message'] = "<p id='error-message'>".$e->getMessage()."</p>";
            UtilsModel::load_page("login_page");
        }
    }

    public static function delete_review(String $review_id){
        ReviewGateway::DeleteReview($review_id);
    }

    public static function invert_newsletter($user_id)
    {
        UserGateway::InvertNewsLetter($user_id);
        $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
        $user->setNewsletter(!$user->isNewsletter());
        $_SESSION['connected_user'] = serialize($user);
        ConnectedModel::load_page('customer-area');
    }

    public static function delete_address($user_id, $street){
        AddressGateway::DeleteAddressByUserIDAndFirstLine($user_id, $street);
    }

    public static function delete_address_complex($user_id, $address_id){
        $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

        AddressGateway::DeleteAddressWithID($user_id, $address_id);
        UserGateway::GetAllAddressForUser($user);


        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/adresses';
        </script>
        <?php
    }

    public static function init_birthlist(string $user_id){
        try {
            BirthlistGateway::InitBirthlist($user_id);
        } catch(PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        }
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    public static function creation_birthlist(string $birthlist_id, string $mother_name, string $father_name, string $message){
        try {
            BirthlistGateway::CreationBirthlist($birthlist_id, $mother_name, $father_name, $message);
        } catch (PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        }
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    public static function add_selected_items_birthlist(string $birthlist_id, $products)
    {
        if($products != null) {
            BirthlistGateway::AddProductArrayToItemList($birthlist_id, $products);
        }
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    public static function delete_product_birthlist($birthlist_id, $products)
    {
        try{
            BirthlistGateway::DeleteNotSelectedProducts($birthlist_id, $products);
        } catch (PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        }
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    public static function back_to_step_2($birthlist_id)
    {
        try{
            BirthlistGateway::UpdateStep($birthlist_id, 2);
        } catch (PDOException $e){
            $_POST['message'] = "<p id='error-message'>Un problème est survenu lors de la modification.</p>";
            ConnectedModel::load_page('customer-area');
        }
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    public static function back_temporary_to_step_2($birthlist_id)
    {
        $_SESSION['temp_step'] = 2;
        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance';
        </script>
        <?php
    }

    /**
     * @param $birthlist_id
     * @param $items_id
     * @param $quantities
     */
    public static function load_birthlist_billing($birthlist_id, $items_id, $quantities)
    {
        if($items_id != null){
            $items = BirthlistGateway::GetItemsWithItemsID($items_id);

            foreach ($items as $item){
                $item = (new BirthListItemContainer($item))->getBirthlistItem();
                foreach ($quantities as $quantity){
                    if(explode('_', $quantity)[1] == $item->getId()){
                        $item->setQuantity(explode('_', $quantity)[0]);
                    }
                }
            }

            $_SESSION['selected_items'] = serialize($items);
        }
        if(empty($_SESSION['selected_items'])){
            ?>
            <script type="text/javascript">
                document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance/partage/<?php echo $birthlist_id; ?>';
            </script>
            <?php
        }
        self::load_page("birthlist_billing");
    }

    public static function load_birthlist_payment($birthlist_id, $civility_billing, $surname_billing, $firstname_billing, $street_billing, $city_billing, $zip_code_billing, $complement_billing, $company_billing)
    {
        if(empty(unserialize($_SESSION['address_billing']))){
            $billing_id = uniqid(). "-billing";
            $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

            $address_billing = new Address($billing_id, $user, $civility_billing, $surname_billing, $firstname_billing,$street_billing,$city_billing,$zip_code_billing,$complement_billing,$company_billing);
            $_SESSION['address_billing'] = serialize($address_billing);
        }

        self::load_page("birthlist_payment");
    }

    public static function init_birthlist_payment(string $birthlist_id, $payment_method)
    {
        if($payment_method == null){
            ?>
            <script type="text/javascript">
                document.location.href='https://www.bebes-lutins.fr/espace-client/liste-de-naissance/paiement/<?php echo $birthlist_id; ?>';
            </script>
            <?php
        }
        else{
            $birthlist = BirthlistGateway::GetBirthlistByID($birthlist_id);
            $selected_items = unserialize($_SESSION['selected_items']);
            $billing_address = (new AddressContainer(unserialize($_SESSION['address_billing'])))->getAddress();
            $user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();$total_price = 0;
            foreach ($selected_items as $item)
            {
                $item = (new BirthListItemContainer($item))->getBirthlistItem();
                $total_price += ($item->getProduct()->getPrice() * $item->getQuantity());
            }

            $order_id = OrderGateway::CreateNewOrderFromBirthlistSelectedItems($birthlist, $user->getId(), $billing_address, $selected_items, $total_price);

            if($payment_method == 1) //CARTE BANCAIRE
            {
                self::do_payment_creditcard_birthlist($order_id, $birthlist_id, $total_price);
            } else if ($payment_method == 2) //CHEQUE BANCAIRE
            {
                self::do_payment_bankcheque_birthlist($order_id, $birthlist_id);
            }
        }
    }

    public static function do_payment_creditcard_birthlist(string $order_id, string $birthlist_id, float $total_price)
    {
        $array = array();
        require("payment/lib/paylineSDK.php");
        require("payment/lib/CONFIG.php");

        $payline = new paylineSDK(MERCHANT_ID, ACCESS_KEY, PROXY_HOST, PROXY_PORT, PROXY_LOGIN, PROXY_PASSWORD, ENVIRONMENT);
        $payline->returnURL = RETURN_URL_BIRTHLIST."&order_id=".$order_id."&birthlist_id=".$birthlist_id;
        $payline->cancelURL = CANCEL_URL_BIRTHLIST ."&order_id=".$order_id."&birthlist_id=".$birthlist_id;
        $payline->notificationURL = NOTIFICATION_URL_BIRTHLIST."&order_id=".$order_id."&birthlist_id=".$birthlist_id;
        $payline->customPaymentPageCode = CUSTOM_PAYMENT_PAGE_CODE;

//VERSION
        $array['version'] = WS_VERSION;

// PAYMENT
        $array['payment']['amount'] = $total_price * 100;
        $array['payment']['currency'] = 978;
        $array['payment']['action'] = PAYMENT_ACTION;
        $array['payment']['mode'] = PAYMENT_MODE;

// ORDER
        $array['order']['ref'] = $order_id;
        $array['order']['amount'] = $total_price * 100;
        $array['order']['currency'] = 978;

// CONTRACT NUMBERS
        $array['payment']['contractNumber'] = CONTRACT_NUMBER;
        $contracts = explode(";",CONTRACT_NUMBER_LIST);
        $array['contracts'] = $contracts;
        $secondContracts = explode(";",SECOND_CONTRACT_NUMBER_LIST);
        $array['secondContracts'] = $secondContracts;

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

    public static function do_payment_bankcheque_birthlist($order_id, $birthlist_id)
    {
        ?>
        <script type="text/javascript">
            document.location.href="https://www.bebes-lutins.fr/liste-de-naissance/paiement-cheque/<?php echo $birthlist_id; ?>";
        </script>
        <?php
    }

    public static function load_thanks_birthlist($order_id)
    {
        UtilsModel::OrderNotification($order_id);

        unset($_SESSION['selected_items']);
        unset($_SESSION['address_billing']);

        self::load_page('thanks_birthlist');
    }

    public static function cancel_birthlist_order($order_id, $birthlist_id)
    {
        $selected_items = unserialize($_SESSION['selected_items']);
        OrderGateway::UpdateOrderStatusWithOrderID($order_id, -11, null);
        BirthlistGateway::CancelSelectedItems($birthlist_id, $selected_items);
        ?>
        <script type="text/javascript">
            document.location.href="https://www.bebes-lutins.fr/liste-de-naissance/partage/<?php echo $birthlist_id; ?>";
        </script>
        <?php
    }
}