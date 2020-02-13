<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-20
 * Time: 08:49
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

$id = $user->getId();
$firstname = $user->getFirstname();
$surname = $user->getSurname();
$mail = $user->getMail();
$phone_number_original = $user->getPhone();
$newsletter = UserGateway::VerifyNewsletterFor($mail);
$registration_date = $user->getRegistrationDateString();

/* TRANSFORMATIONS */
if($phone_number_original == null) $phone_number = "Aucun numéro";
else {
    $phone_number = $phone_number_original;

    /*if(substr($phone_number_original, 0, 1) != 0){
        $phone_number = "0" . $phone_number_original;
        $phone_number_original = "0" . $phone_number_original;
    }
    else $phone_number = $phone_number_original;
    $phone_number = chunk_split($phone_number, 2, ' ');*/
}

$number_of_orders = 0;
foreach ($user->getOrderList() as $order) $number_of_orders = $number_of_orders + 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espace client - Bebes Lutins</title>
    <meta name="description" content="Accedez a votre espace client pour suivre vos commandes et mettre a jour vos informations."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical">
    <div id="customer-area2" class="desktop vertical">
        <div id="customer-area-header" class="vertical">
            <div id="hello" class="vertical">
                <h2>Bonjour <?php echo $firstname . " " . $surname;?></h2>
                <p>Bienvenue dans votre espace</p>
            </div>
            <div id="customer-area-tabs" class="horizontal">
                <a href="#" class="selected">Mon profil</a>
                <a href="https://www.bebes-lutins.fr/espace-client/commandes">Mes commandes</a>
                <a href="https://www.bebes-lutins.fr/espace-client/adresses">Mes adresses</a>
                <a href="https://www.bebes-lutins.fr/espace-client/liste-envie">Liste d'envie</a>
            </div>
        </div>
        <div id="customer-area-inner" class="vertical">
            <div class="personnal-informations">
                <H3>MES INFORMATIONS PERSONNELLES</H3>
                <div class="customer-area-bloc horizontal">
                    <div class="information vertical">
                        <p>Inscrit depuis le : <?php echo $registration_date; ?></p>
                        <p><?php echo $firstname . " " . $surname;?></p>
                        <p><?php echo $mail;?></p>
                        <p>Date de naissance : Aucune date renseignée</p>
                        <p>Téléphone : <?php echo $phone_number;?></p>
                    </div>
                    <div class="edit-button-container vertical centered">
                        <button id="button-open-informations-form" onclick="open_informations_form()"><i class="fas fa-pencil-alt"></i> Modifier</button>
                    </div>
                </div>
                <form id="info-form" class="informations-form vertical transition-fast" method="post" action="https://www.bebes-lutins.fr/espace-client/modifier-informations">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="mail" value="<?php echo $mail; ?>">

                    <label for="surname" class="closed">Nom :</label>
                    <input id="surname" type="text" name="surname" value="<?php echo $surname;?>" placeholder="Votre nom de famille" class="closed" required>
                    <label for="firstname" class="closed">Prénom :</label>
                    <input id="firstname" type="text" name="firstname" value="<?php echo $firstname;?>" placeholder="Votre prénom" class="closed" required>
                    <label for="mail" class="closed">Adresse Email :</label>
                    <input id="mail" type="email" name="mail_fake" value="<?php echo $mail;?>" placeholder="Votre adresse email" class="closed" disabled>
                    <label for="phone" class="closed">Téléphone :</label>
                    <input id="phone" type="tel" name="phone" value="<?php echo $phone_number_original;?>" placeholder="Votre numéro de téléphone" class="closed">
                    <button type="submit" class="closed">Valider</button>
                </form>
            </div>
            <div class="password">
                <H3>MOT DE PASSE</H3>
                <div class="customer-area-bloc horizontal">
                    <div class="password-info vertical centered">
                        <p><i class="fas fa-shield-alt" style="color: green;"></i> Vous pouvez modifier votre mot de passe à tout moment.</p>
                    </div>
                    <div class="edit-button-container vertical centered">
                        <button id="button-open-pwd-form" onclick="open_password_form()"><i class="fas fa-pencil-alt"></i> Modifier</button>
                    </div>
                </div>
                <form id="pwd-form" class="password-form vertical transition-fast" method="post" action="https://www.bebes-lutins.fr/espace-client/modifier-mot-de-passe">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="mail" value="<?php echo $mail; ?>">

                    <label for="old_password" class="closed">Mot de passe actuel :</label>
                    <input id="old_password" type="password" name="old_password" placeholder="Votre mot de passe actuel" class="closed" required>
                    <label for="new_password" class="closed">Nouveau mot de passe :</label>
                    <input id="new_password" type="password" name="new_password" placeholder="Un nouveau mot de passe" class="closed" required>
                    <label for="new_password_confirm" class="closed">Confirmez le mot de passe :</label>
                    <input id="new_password_confirm" type="password" name="new_password_confirm" placeholder="Retaper votre nouveau mot de passe" class="closed" required>
                    <button type="submit" class="closed">Valider</button>
                </form>
            </div>
            <div class="newsletter">
                <H3>NEWSLETTER</H3>
                <div class="customer-area-bloc horizontal">
                    <div class="informations vertical centered">
                    <?php if ($newsletter == true) { ?>
                        <p><i class="far fa-check-circle" style="color: green;"></i> Vous avez indiqué vouloir recevoir les actualités Bébés Lutins.</p>
                    <?php } else { ?>
                        <p><i class="far fa-circle"></i>  Vous avez indiqué ne pas vouloir recevoir les actualités Bébés Lutins. :-(</p>
                    <?php }?>
                    </div>
                    <div class="edit-button-container vertical centered">
                    <?php if($newsletter) {?>
                        <button onclick="newsletter_invert('<?php echo $user->getId(); ?>')">Se désinscrire des newsletters</button>
                    <?php } else { ?>
                        <button onclick="newsletter_invert('<?php echo $user->getId(); ?>')">S'inscrire aux newsletters</button>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="logout">
                <H3>DECONNEXION</H3>
                <div class="customer-area-bloc">
                    <button onclick="logout()"><i class="fas fa-sign-out-alt"></i> Se deconnecter</button>
                </div>
            </div>
        </div>
    </div>
    <div id="customer-area-mobile" class="mobile vertical centered">
        <H1>Mon compte</H1>
        <div class="customer-area-bloc vertical">
            <H2>Mes commandes</H2>
            <button onclick="redirect_user_to('mobile/commandes')">Afficher mes commandes (<?php echo $number_of_orders;?>)</button>
        </div>
        <div class="customer-area-bloc vertical">
            <H2>Mes informations</H2>
            <div class="user-informations">
                <p><?php echo $firstname . " " . $surname;?></p>
                <p><?php echo $mail;?></p>
                <p><?php echo $phone_number;?></p>
            </div>
            <button onclick="redirect_user_to('mot-de-passe')">Modifier mon mot de passe</button>
            <button>Modifier mes informations</button>
        </div>
        <div class="customer-area-bloc vertical">
            <h2>Mes adresses</h2>
            <button>Ajouter une adresse</button>
            <button>Liste de mes adresses</button>
        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
<script>
    function redirect_user_to(user_page){
        document.location.href= "https://www.bebes-lutins.fr/espace-client/"+user_page;
    }

    function open_informations_form(){
        var children_display = Array.from(document.getElementById("info-form").children);
        children_display.forEach(function (entry) {
            entry.setAttribute('class', 'opened');
        });
        document.getElementById("info-form").style.padding = "1em 0";
        document.getElementById("button-open-informations-form").setAttribute('onClick', 'close_informations_form()');
    }

    function close_informations_form(){
        var children_display = Array.from(document.getElementById("info-form").children);
        children_display.forEach(function (entry) {
            entry.setAttribute('class', 'closed');
        });
        document.getElementById("info-form").style.padding = "0";
        document.getElementById("button-open-informations-form").setAttribute('onClick', 'open_informations_form()');
    }

    function open_password_form(){
        var children_display = Array.from(document.getElementById("pwd-form").children);
        children_display.forEach(function (entry) {
            entry.setAttribute('class', 'opened');
        });
        document.getElementById("pwd-form").style.padding = "1em 0";
        document.getElementById("button-open-pwd-form").setAttribute('onClick', 'close_password_form()');
    }

    function close_password_form(){
        var children_display = Array.from(document.getElementById("pwd-form").children);
        children_display.forEach(function (entry) {
            entry.setAttribute('class', 'closed');
        });
        document.getElementById("pwd-form").style.padding = "0";
        document.getElementById("button-open-pwd-form").setAttribute('onClick', 'open_password_form()');
    }

    function logout(){
        document.location.href= "https://www.bebes-lutins.fr/espace-client/deconnexion";
    }

    function newsletter_invert(user_id){
        document.location.href= "https://www.bebes-lutins.fr/espace-client/modification-newsletter/" + user_id;
    }
</script>

<script>
    var password = document.getElementById("new_password")
        , confirm_password = document.getElementById("new_password_confirm");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Les mots de passe ne correspondent pas.");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>

<?php if(isset($_POST['message_password'])){ ?>
    <script>
        alert("<?php echo $_POST['message_password']; ?>")
    </script>
<?php } ?>
</body>
</html>
