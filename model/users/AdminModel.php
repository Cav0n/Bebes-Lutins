<?php


/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:16
 */

class AdminModel
{
    public static function load_page(String $page)
    {
        global $view_rep;
        switch ($page){
            case 'dashboard':
                require("$view_rep/html/administration/tabs/orders/index.php");
                break;

            case 'dashboard4':
                require("$view_rep/html/administration/4.0/tabs/orders/in-preparation/all.php");
                break;

            case 'add_category':
                require("$view_rep/html/administration/management/new/category.php");
                break;

            case 'edit_category':
                require("$view_rep/html/administration/management/edit/category.php");
                break;

            case 'add_product':
                require("$view_rep/html/administration/management/new/product.php");
                break;

            case 'edit_product':
                require("$view_rep/html/administration/management/edit/product.php");
                break;

            case 'add_voucher':
                require("$view_rep/html/administration/management/new/voucher.php");
                break;

            case 'show_bill':
                require("$view_rep/html/administration/management/order.php");
                break;

            case 'user_page':
                require("$view_rep/html/administration/management/user.php");
                break;

            case 'research-user-test':
                require("$view_rep/html/tests/research-user-test.php");
                break;

            default :
                $_SESSION['error-message'] = "Cette page n'existe pas.";
                require("$view_rep/html/main/error.php");
                break;
        }
    }

    public static function load_dashboard_tab($header_tab, $option)
    {
        global $view_rep;
        switch ($header_tab){
            case 'orders':
                if($option == null){
                    require("$view_rep/html/administration/tabs/orders/index.php");
                } else if($option == 'payed') {
                    require("$view_rep/html/administration/tabs/orders/index.php");
                } else if($option == 'payment') {
                    require("$view_rep/html/administration/tabs/orders/waiting-for-payment.php");
                } else if($option == 'sended') {
                    require("$view_rep/html/administration/tabs/orders/sended.php");
                } else if($option == 'canceled') {
                    require("$view_rep/html/administration/tabs/orders/canceled.php");
                }
                break;

            case 'reviews':
                if($option == null){
                    require("$view_rep/html/administration/tabs/reviews/index.php");
                } else if($option == "validated") {
                    require("$view_rep/html/administration/tabs/reviews/index.php");
                } else if($option == "declined") {
                    require("$view_rep/html/administration/tabs/reviews/declined.php");
                }
                break;

            case 'products':
                if($option == null){
                    require("$view_rep/html/administration/tabs/products/index.php");
                }
                break;

            case 'users':
                if($option == null){
                    require("$view_rep/html/administration/tabs/users/index.php");
                } else if($option == 'administrateurs'){
                    require("$view_rep/html/administration/tabs/users/administrators.php");
                } else if($option == 'utilisateurs'){
                    require("$view_rep/html/administration/tabs/users/index.php");
                }
                break;

            case 'various':
                if($option == null){
                    require("$view_rep/html/administration/tabs/various/index.php");
                } else if($option == "coupons") {
                    require("$view_rep/html/administration/tabs/various/voucher.php");
                } else if($option == "restauration") {
                    require("$view_rep/html/administration/tabs/various/backup.php");
                } else if($option == "chiffre") {
                    require("$view_rep/html/administration/tabs/various/index.php");
                }
                break;

            case 'search':
                if($option == null) {
                    require("$view_rep/html/administration/tabs/search/index.php");
                } else if($option == "produits") {
                    require("$view_rep/html/administration/tabs/search/products.php");
                } else if($option == "utilisateurs") {
                    require("$view_rep/html/administration/tabs/search/index.php");
                }
                break;
        }
    }

    public static function load_administration_header()
    {
        global $view_rep;
        require("$view_rep/html/administration/components/header-dashboard.php");
    }

    public static function load_administration4_header(){
        global $view_rep;
        require("$view_rep/html/administration/4.0/components/header.php");
    }

    public static function load_order_display(){
        global $view_rep;

        require("$view_rep/html/administration/components/order_display.php");
    }

    public static function add_category(String $nom, $parent, String $description){
        $_SESSION['header_tab'] = "products";

        $nom = str_replace("'", "’",ucfirst($nom));
        $description = nl2br(str_replace("'", "’",$description));

        $nomImage = self::UploadImage(str_replace(" ","_",$nom), 'categories');
        if($parent == null){
            $parent = 'null';
        }

        if ($nomImage == null){
            $_POST['error-message-products'] = "Erreur lors de l'Upload de l'image." . $_POST['ErreurUpload'];
            self::load_page('dashboard');
        }
        try{
            CategoryGateway::AddCategory($nom, $parent,$nomImage, $description, 0);
        }catch (PDOException $e) {
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            self::load_page('dashboard');
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function edit_category(String $name, String $old_image_name, String $description, String $old_name, $rank){
        $_SESSION['header_tab'] = "products";

        $name = str_replace("'", "’",ucfirst($name));
        $description = nl2br(str_replace("'", "’",$description));

        if( !empty($_FILES['image']['name']) ) {
            $image_name = self::UploadImage(str_replace(" ", "_", $name), 'categories');
            if ($image_name == null) {
                $_POST['error-message-products'] = "Erreur lors de l'Upload de l'image." . $_POST['ErreurUpload'];
                self::load_page('dashboard');
            }
        } else $image_name = $old_image_name;

        try{ CategoryGateway::EditCategory($name, $image_name, $description, $old_name, $rank);}
        catch (PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            self::load_page('dashboard');
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php

    }

    public static function delete_category(String $name){
        $_SESSION['header_tab'] = "products";

        try{CategoryGateway::DeleteCategory($name);}
        catch(PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            self::load_page('dashboard');
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function add_product(String $name, float $price, int $stock, String $description_big, String $description_small, String $category, $custom_id){
        $_SESSION['header_tab'] = "products";

        $id = uniqid("product-");
        $custom_id = strtoupper($custom_id);

        $name = str_replace("'", "’",ucfirst($name));
        $description_big = nl2br(str_replace("'", "’",$description_big));
        $description_small = nl2br(str_replace("'", "’",$description_small));

        $image_name = self::UploadImage(str_replace(" ","_",$name), 'products');

        if ($image_name == null){
            $_POST['error-message-products'] = "Erreur lors de l'Upload de l'image." . $_POST['ErreurUpload'];
            self::load_page('dashboard');
        }
        else {
            $creation_date = date('Y-m-d');
            try{ProductGateway::AddProduct($id, $name, $name, $price, $stock, $description_big, $description_small, $category, $creation_date, $image_name, $custom_id, null, 0);}
            catch (PDOException $e){
                $_POST['error-message-products'] = "Erreur BDD : " . $e;
                self::load_page('dashboard');
            }
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
    }

    public static function add_highlight_product(String $product_id){
        ProductGateway::AddHighlightProduct($product_id);
        ?><script>document.location.href="https://www.bebes-lutins.fr/dashboard"</script><?php
    }

    public static function remove_highliht_product(String $product_id){
        ProductGateway::RemoveHighlightProduct($product_id);
        ?><script>document.location.href="https://www.bebes-lutins.fr/dashboard"</script><?php
    }

    public static function edit_product(String $id_copy,String $id, String $name, float $price, int $stock, String $description_big, String $description_small, String $old_image, String $custom_id){
        $_SESSION['header_tab'] = "products";

        $name = str_replace("'", "’",ucfirst($name));
        $description_big = (str_replace("'", "’",$description_big));
        $description_small = (str_replace("'", "’",$description_small));

        if( !empty($_FILES['image']['name']) ) unlink("view/assets/images/products/$old_image");
        $image_name = self::UploadImage(str_replace(" ","_",$name), 'products');
        if($image_name == null) $image_name = $old_image;

        $creation_date = date('Y-m-d');
        try{ProductGateway::UpdateProduct($id_copy, $id,  $name, $name, $price, $stock, $description_big, $description_small, $creation_date, $image_name, $custom_id, null, 0);}
        catch (PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            self::load_page('dashboard');
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function clone_product(String $category_clone, String $product_id){
        try{
            $id = uniqid("product-");

            ProductGateway::CloneProduct($category_clone, $product_id, $id);
        } catch (PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function copy_product(String $category, String $old_id){
        unset($_SESSION['test']);
        try{
            $new_id = uniqid("product-");
            ProductGateway::CopyProduct($category, $old_id, $new_id);
            $_SESSION['id_product'] = $new_id;
        } catch (PDOException $e) {
            $_SESSION['test'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/modifier-produit-page"?>';
        </script>
        <?php
    }

    public static function move_product(String $category, String $id){
        unset($_SESSION['test']);
        try{
            ProductGateway::MoveProduct($category, $id);
        } catch (PDOException $e) {
            $_SESSION['test'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function add_thumbnail(String $id_product){
        $name = uniqid("thumbnails-".$id_product."-");
        $id = $name;
        $thumbnails_name = self::UploadImage(str_replace(" ","_", $name), 'thumbnails');

        try{
            ProductGateway::AddThumbnails($id, $thumbnails_name, $id_product);
        } catch (PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            self::load_page('dashboard');
        }
        $_SESSION['id_product'] = $id_product;
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/modifier-produit-page"?>';
        </script>
        <?php
    }

    public static function delete_thumbnail(String $thumbnail_name, String $product_id){
        $_SESSION['header_tab'] = "products";

        try{
            ProductGateway::DeleteThumbnail($thumbnail_name, $product_id);
        } catch (PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
        $_SESSION['id_product'] = $product_id;
        ?>

        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/modifier-produit-page"?>';
        </script>
        <?php
    }

    public static function delete_product(String $id){
        $_SESSION['header_tab'] = "products";

        try {
            ProductGateway::DeleteProduct($id);
        } catch(PDOException $e){
            $_POST['error-message-products'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab-products"?>';
        </script>
        <?php
    }

    public static function delete_product2($id){
        try{
            ProductGateway::DeleteProduct($id);
        } catch (PDOException $e) {

        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4/produits/tous-les-produits"?>';
        </script>
        <?php
    }

    public static function change_status_order(String $order_id, int $status, $admin_message){
        try{
            $order = OrderGateway::GetOrderFromDBByID($order_id);
            OrderGateway::UpdateOrderStatusWithOrderID($order_id, $status, $admin_message);
            $order->setStatus($status);

            $firstname = $order->getCustomer()->getFirstname();
            $surname = $order->getCustomer()->getSurname();
            $price = str_replace("EUR", "€", money_format("%.2i", $order->getTotalPrice() + $order->getShippingPrice()));
            $string_status = $order->statusToString();
            ?>

            <script type="text/javascript">
                console.log(<?php echo $string_status; ?>);
            </script>

            <?php
            if($admin_message != null) {
                $admin_message = "
                Vous avez un message de notre part avec votre commande :
            $admin_message";
            }

            $message = "Bonjour $firstname $surname, 
    Nous vous informons que votre commande de $price a changé d'état !
    Elle est maintenant \"$string_status\".
    $admin_message
    
    Cordialement,
    Toute l'équipe Bébés Lutins.";
            UtilsModel::EnvoieNoReply($order->getCustomer()->getMail(), "Mise a jour de votre commande", $message);
        } catch (PDOException $e){
            $_POST['error-message-orders'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4"?>';
        </script>
        <?php
    }

    public static function add_voucher_page(){
        self::load_page('add_voucher');
    }

    public static function add_voucher(String $name, $discount, String $type, String $date_beginning, String $date_end, int $number_of_usage){
        $_SESSION['header_tab'] = "various";

        $id=uniqid("voucher-");
        try{
            VoucherGateway::AddVoucher($id, strtoupper($name), $discount, $type, $date_beginning, $date_end, $number_of_usage);
        } catch (PDOException $e){
            $_POST['error-message-various'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard"?>';
        </script>
        <?php
    }

    public static function delete_voucher(String $id_voucher){
        $_SESSION['header_tab'] = "various";
        try{
            VoucherGateway::DeleteVoucher($id_voucher);
        } catch(PDOException $e){
            $_POST['error-message-various'] = "Erreur BDD : " . $e;
            ?>
            <script type="text/javascript">
                document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard"?>';
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard"?>';
        </script>
        <?php
    }

    public static function UploadImage($nom, $dossier)
    {
        if($dossier == 'products'){
            define('TARGET', "view/assets/images/products/");    // Repertoire cible
        }
        else if($dossier == 'categories'){
            define('TARGET', "view/assets/images/categories/");    // Repertoire cible
        }
        else if($dossier == 'thumbnails'){
            define('TARGET', "view/assets/images/thumbnails/");
        }
        else define('TARGET', 'vues/assets/images/');    // Repertoire cible
        define('MAX_SIZE', 10000000);    // Taille max en octets du image
        define('WIDTH_MAX', 5000);    // Largeur max de l'image en pixels
        define('HEIGHT_MAX', 5000);    // Hauteur max de l'image en pixels

// Tableaux de donnees
        $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
        $infosImg = array();

// Variables
        $extension = '';
        $message = '';
        $nomImage = '';

        /************************************************************
         * Creation du repertoire cible si inexistant
         *************************************************************/
        if( !is_dir(TARGET) ) {
            if( !mkdir(TARGET, 0755) ) {
                exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
            }
        }

        /************************************************************
         * Script d'upload
         *************************************************************/
        if(!empty($_POST))
        {
            // On verifie si le champ est rempli
            if( !empty($_FILES['image']['name']) )
            {
                // Recuperation de l'extension du image
                $extension  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                // On verifie l'extension du image
                if(in_array(strtolower($extension),$tabExt))
                {
                    // On recupere les dimensions du image
                    $infosImg = getimagesize($_FILES['image']['tmp_name']);

                    // On verifie le type de l'image
                    if($infosImg[2] >= 1 && $infosImg[2] <= 14)
                    {
                        // On verifie les dimensions et taille de l'image
                        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['image']['tmp_name']) <= MAX_SIZE))
                        {
                            // Parcours du tableau d'erreurs
                            if(isset($_FILES['image']['error'])
                                && UPLOAD_ERR_OK === $_FILES['image']['error'])
                            {
                                // On renomme le image
                                $nomImage = strtolower($nom .'.'. $extension);

                                // Si c'est OK, on teste l'upload
                                if(move_uploaded_file($_FILES['image']['tmp_name'], TARGET.$nomImage))
                                {
                                    $_POST["ErreurUpload"] = 'Upload réussi !';
                                    return $nomImage;
                                }
                                else
                                {
                                    // Sinon on affiche une erreur systeme
                                    $_POST["ErreurUpload"] = 'Problème lors de l\'upload !';
                                }
                            }
                            else
                            {
                                $_POST["ErreurUpload"] = 'Une erreur interne a empêché l\'uplaod de l\'image';
                            }
                        }
                        else
                        {
                            // Sinon erreur sur les dimensions et taille de l'image
                            $_POST["ErreurUpload"] = 'Erreur dans les dimensions de l\'image !';
                        }
                    }
                    else
                    {
                        // Sinon erreur sur le type de l'image
                        $_POST["ErreurUpload"] = 'Le image à uploader n\'est pas une image !';
                    }
                }
                else
                {
                    // Sinon on affiche une erreur pour l'extension
                    $_POST["ErreurUpload"] = 'L\'extension du image est incorrecte !';
                }
            }
            else
            {
                // Sinon on affiche une erreur pour le champ vide
                $_POST["ErreurUpload"] = 'Veuillez choisir une image!';
            }
        }
        return null;
    }

    public static function UploadMutlipleImages(){
        $first_image_name = $_FILES["uploadFile"]["name"][0];

        for($i=0;$i<count($_FILES["uploadFile"]["name"]);$i++)
        {
            $uploadfile=$_FILES["uploadFile"]["tmp_name"][$i];
            $folder="view/assets/images/tests/";

            move_uploaded_file($_FILES["uploadFile"]["tmp_name"][$i], $folder.$_FILES["uploadFile"]["name"][$i]);
        }
        return $first_image_name;
    }

    public static function TestMail(){
        require_once('vendor/phpmailer/phpmailer/src/PHPMailer.php');
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.ionos.fr';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'no-reply@bebes-lutins.fr';                 // SMTP username
            $mail->Password = 'Acty-63300';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('no-reply@bebes-lutins.fr', 'No reply Bebes Lutins');
            $mail->addAddress('cav0n@hotmail.fr');     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    public static function delete_review($review_id)
    {
        ReviewGateway::DeleteReview($review_id);
        ?>
        <script type="text/javascript">
            document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard/tab/reviews"?>';
        </script>
        <?php
    }

    public static function load_page_dashboard($section, $page, $option)
    {
        global $view_rep;
        switch ($section){
            case "commandes":
                if($page == "en-cours" || $page == null){
                    if ($option == "toutes" || $option == null) require("$view_rep/html/administration/4.0/tabs/orders/in-preparation/all.php");
                    if ($option == "en-preparation") require("$view_rep/html/administration/4.0/tabs/orders/in-preparation/in-preparation.php");
                    if ($option == "en-attente-de-paiement") require("$view_rep/html/administration/4.0/tabs/orders/in-preparation/waiting-for-payment.php");
                } else if($page == "terminees"){
                    if ($option == "toutes" || $option == null) require("$view_rep/html/administration/4.0/tabs/orders/ended/all.php");
                    if ($option == "en-cours-de-livraison") require("$view_rep/html/administration/4.0/tabs/orders/ended/shipping.php");
                    if ($option == "livree") require("$view_rep/html/administration/4.0/tabs/orders/ended/delivered.php");
                    if ($option == "annulee") require("$view_rep/html/administration/4.0/tabs/orders/ended/canceled.php");
                } else if($page == "modifier-etat"){
                    self::change_status_order($_POST['id'], $_POST['new_status'], null);
                }
                break;

            case "produits":
                if($page == "tous-les-produits" || $page == null) require("$view_rep/html/administration/4.0/tabs/products/all/all.php");
                if($page == "stocks") require("$view_rep/html/administration/4.0/tabs/products/stocks/all.php");
                if($page == "nouveau") require("$view_rep/html/administration/4.0/tabs/products/edit/new.php");
                if($page == "edition") require("$view_rep/html/administration/4.0/tabs/products/edit/edition.php");
                if($page == "sauvegarder") {self::save_product($_REQUEST['product_id']);}
                if($page == "importer") require("$view_rep/html/administration/4.0/tabs/products/edit/import.php");
                if($page == "supprimer") {self::delete_product2($_REQUEST['product_id']);}
                if($page == "miseajourstock") {self::updateProductStock($_REQUEST['product_id'], $_REQUEST['quantity'], $_REQUEST['quantity-checkbox']);}
                break;

            case "clients":
                if($page == "tous-les-clients" || $page == null){
                    if($option == "tous" || $option == null) require("$view_rep/html/administration/4.0/tabs/customers/all.php");
                }
                break;

            case "avis":
                if($page == "tous-les-avis" || $page == null){
                    if($option == "acceptes" || $option == null) require("$view_rep/html/administration/4.0/tabs/reviews/accepted.php");
                    if($option == "rejetes") require("$view_rep/html/administration/4.0/tabs/reviews/rejected.php");
                }
                break;

            case "reductions":
                if($page == "tous-les-codes" || $page == null){
                    if($option == "tous" || $option == null) require("$view_rep/html/administration/4.0/tabs/vouchers/codes/all.php");
                    if($option == "actifs") require("$view_rep/html/administration/4.0/tabs/vouchers/codes/active.php");
                    if($option == "programmes") require("$view_rep/html/administration/4.0/tabs/vouchers/codes/scheduled.php");
                    if($option == "expires") require("$view_rep/html/administration/4.0/tabs/vouchers/codes/expired.php");
                }
                if($page == "creation") {
                    if ($option == null) require("$view_rep/html/administration/4.0/tabs/vouchers/edit/new.php");
                }
                break;

            case "analyses":
                if($page == "tableau-de-bord"){
                    if($option == "tous" || $option == null) require("$view_rep/html/administration/4.0/tabs/analysis/dashboard/dashboard.php");
                }
                break;
        }
    }

    public static function save_product($id){
        if($id == null) {
            $error_product_creation = false;

            $id = uniqid("product-");
            $reference = strtoupper($_POST['reference']);
            $name = str_replace("'", "’",ucfirst($_POST['name']));
            $ceo_name = str_replace("'", "’",ucfirst($_POST['ceo_name']));
            $description = nl2br(str_replace("'", "’",$_POST['description']));
            $ceo_description = nl2br(str_replace("'", "’",$_POST['ceo_description']));
            $image_name = $_POST['image_name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $categories = $_POST['category'];
            $categories_string = "";
            foreach ($categories as $category){
                $categories_string = $categories_string . $category . ";";
            }
            $thumbnails_name = $_POST['thumbnails_name'];
            $tags = $_POST['tags'];
            $hide = $_POST['hide'];
            if($hide == null) $hide = 0;
            else $hide = 1;
            try{
                $creation_date = date('Y-m-d');
                ProductGateway::AddProduct($id, $name, $ceo_name, $price, $stock, $description, $ceo_description, $categories_string, $creation_date, $image_name, $reference, $tags, $hide, $thumbnails_name);
            } catch (PDOException $e){
                $error_product_creation = true;
                $error_message = "Erreur BDD : " . $e;
            }
            if($error_product_creation){
                $_SESSION['error_message'] = $error_message;
                $_SESSION['reference'] = $reference;
                $_SESSION['name'] = $name;
                $_SESSION['description'] = $description;
                $_SESSION['ceo_name'] = $ceo_name;
                $_SESSION['ceo_description'] = $ceo_description;
                $_SESSION['price'] = $price;
                $_SESSION['stock'] = $stock;
                $_SESSION['tags'] = $tags;
                $_SESSION['hide'] = $hide;
                $_SESSION['category'] = $categories;
                ?>
                <script type="text/javascript">
                    document.location.href='https://www.bebes-lutins.fr/dashboard4/produits/nouveau';
                </script>
                <?php
            }
            else {
                ?>
                <script type="text/javascript">
                    document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4/produits/edition/".$id; ?>';
                </script>
                <?php
            }
        } else {
            $reference = strtoupper($_POST['reference']);
            $name = str_replace("'", "’",ucfirst($_POST['name']));
            $ceo_name = str_replace("'", "’",ucfirst($_POST['ceo_name']));
            $description = nl2br(str_replace("'", "’",$_POST['description']));
            $ceo_description = nl2br(str_replace("'", "’",$_POST['ceo_description']));
            if ($_FILES['uploadFile'] != null) {
                $image_name = self::UploadMutlipleImages();
            } else $image_name = $_POST['image_name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $categories = $_POST['category'];
            $categories_string = "";
            $thumbnails_name = $_POST['thumbnails_name'];
            foreach ($categories as $category){
                $categories_string = $categories_string . $category . ";";
            }
            $tags = $_POST['tags'];
            $hide = $_POST['hide'];

            $creation_date = date('Y-m-d');
            try{ProductGateway::UpdateProduct2($_POST['id_copy'], $id, $name, $categories_string, $ceo_name, $price, $stock, $description, $ceo_description, $creation_date, $image_name, $reference, $tags, $hide, $thumbnails_name); }
            catch (PDOException $e){
                $_POST['error-message-products'] = "Erreur BDD : " . $e;
                ?>
                <script type="text/javascript">
                    //document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4/produits/edition/".$id; ?>';
                </script>
                <?php
            }
            ?>
            <script type="text/javascript">
                //document.location.href='<?php echo "https://www.bebes-lutins.fr/dashboard4/produits/edition/".$id; ?>';
            </script>
            <?php
        }
    }

    public static function updateProductStock($id, $stock, $type){
        if($type == "add"){
            $stock = (new ProductContainer(ProductGateway::SearchProductByID2($id)))->getProduct()->getStock() + $stock;
        }

        ProductGateway::UpdateStock($id, $stock);

        ?>
        <script type="text/javascript">
            document.location.href='https://www.bebes-lutins.fr/dashboard4/produits/stocks';
        </script>
        <?php
    }
}