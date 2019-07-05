<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:15
 */

class VisitorModel
{
    public static function load_page(String $page)
    {
        global $view_rep;
        switch ($page){
            case 'accueil':
                require("$view_rep/html/main/index.php");
                break;

            case 'shopping_cart_delivery':
                require("$view_rep/html/shopping-cart/order-delivery.php");
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

    public static function registration(String $surname, String $firstname, String $mail, String $phone, String $password, $newsletter){
        if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
            $_POST['message'] = "<p style='color: #b41620; text-align: center;'>Veuillez vérifier que vous n'êtes pas un robot grâce au Captcha.</p>";
            UtilsModel::load_page('registration_page');
        } else {
            $secretKey = "6Ldj9p4UAAAAAO-lFqcTg5irY1504Y_NCU2S01js";
            $ip = $_SERVER['REMOTE_ADDR'];
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);
            // should return JSON with success as true
            if ($responseKeys["success"]) {
                $hashed_password = password_hash($password,PASSWORD_DEFAULT); //Password encryption
                $id = substr(UtilsModel::replace_accent($firstname), 0, 3) . substr(UtilsModel::replace_accent($surname), 0, 3) . date("d") . date("m") . date("h") . date("i") . date("s"); //UserID generation
                $verification_key = bin2hex(openssl_random_pseudo_bytes(10, $cstrong)); //Key for email verification
                $shopping_cart_id = (substr($firstname, 0, 3) . substr($surname, 0, 3) . date("Y") . date("m") . date("d") . date("h") . date("i") . date("s")); //Shopping Cart ID generation
                $birthlist_id = "birthlist - " . substr($firstname, 0, 3) . substr($surname, 0, 3) . date("d") . date("m") . date("h") . date("i") . date("s"); //Birthlist ID generation

                if($newsletter != null && $newsletter = 'yes') $newsletter = 1;
                else{ $newsletter = 0; }

                /*$id_url = $id . "_";
                $message = "Bienvenue sur Bébés Lutins !
                    <BR>
                    <BR>Pour activer votre compte veuillez cliquer <a href='https://www.bebes-lutins.fr/activation/$id_url$verification_key'>ici</a> (vous pouvez aussi copier/coller le lien suivant) :
                    <BR>https://www.bebes-lutins.fr/activation/$id_url$verification_key
                    <BR>
                    <BR>---------
                    <BR>Ceci est un email automatique veuillez ne pas y répondre.";*/

                $message = "Nous vous envoyons cet e-mail car vous avez récemment crée un compte sur le site www.bebes-lutins.fr. <BR>".
                    "Si ce n'est pas le cas veuillez contacter le service client à l'adresse suivante : <a href='https://www.bebes-lutins.fr/contact'>https://www.bebes-lutins.fr/contact</a><BR>".
                    "Vous pouvez aussi nous envoyer un mail à <a href='mailto:contact@bebes-lutins.fr'>contact@bebes-lutins.fr</a> <BR>".
                    "<BR>".
                    "Cordialement, <BR>".
                    "L'équipe Bébés Lutins";

                try{
                    $erreur = UserGateway::Register($id, $surname,$firstname,$mail, $phone, $hashed_password, $shopping_cart_id, $birthlist_id, $verification_key, $newsletter);
                    if($erreur == "mail") {
                        $_POST['message'] = "<p class='medium' id='error-message'>Un compte avec cette adresse mail existe déjà.</p>";
                        UtilsModel::load_page('registration_page');
                    }else{
                        $_POST['message'] = "<p class='medium' id='infos-message'>Votre compte a bien été crée. Vous pouvez vous connecter.</p>";
                        UtilsModel::EnvoieNoReply($mail, "Bienvenue chez Bébés Lutins !", $message);
                        UtilsModel::load_page('login_page');
                    }
                } catch(PDOException $e){
                    throw new PDOException($e);
                } catch(Exception $e){
                    throw new Exception($e);
                }
            }
        }


    }

    public static function activation(String $user_id, String $key){
        $activated = false;
        try{
            $activated = UserGateway::Activation($user_id, $key);
        } catch (PDOException $e){
            $_POST['message'] = "<p class='medium' id='error-message'>Une erreur est survenu : $e.</p>";
            ?>
            <script type="text/javascript">
                document.location.href="https://www.bebes-lutins.fr/espace-client/connexion";
            </script>
            <?php
        }
        if($activated){
            $_POST['message'] = "<p class='medium' id='infos-message'>Votre compte est dorénavant activé.</p>";
            ?>
            <script type="text/javascript">
                document.location.href="https://www.bebes-lutins.fr/espace-client/connexion";
            </script>
            <?php
        }
    }

    public static function login(String $mail, String $password){
        try{
            $user = UserGateway::login($mail, $password);
            if($user->getFirstname()!=null){
                $_SESSION['connected_user'] = serialize($user);
                $_SESSION['password'] = $password;
                if(isset($_SESSION['redirect_url'])){
                    ?>
                    <script type="text/javascript">
                        document.location.href = '<?php echo $_SESSION['redirect_url'];?>';
                    </script>
                    <?php
                }
                else {
                    ?>
                    <script type="text/javascript">
                        document.location.href = 'https://www.bebes-lutins.fr/espace-client'
                    </script>
                    <?php
                }
            }
        } catch(PDOException $e){
            $_SESSION['error_message'] = $e;
            UtilsModel::load_page("error");
        } catch(Exception $e){
            $_SESSION['error_message'] = $e;
            UtilsModel::load_page("error");
        }
    }
}