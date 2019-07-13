<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 30/11/2018
 * Time: 11:51
 */

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Contact - Bebes Lutins</title>
    <meta name="description" content="Retrouvez nos coordonnées et l'emplacement de notre atelier, et contactez nous grâce à notre formulaire de contact."/>
    <?php UtilsModel::load_head();?>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>

    <div id="static-container" class="desktop vertical">
        <h1>Contactez-nous</h1>
        <div class="static-bloc vertical centered">
            <div class="static-bloc-inner horizontal between">
                <div id='contact-informations' class="vertical centered">
                    <div class="vertical contact-information">
                        <p><b>Par mail</b><BR>
                        Vous pouvez nous contacter par mail à l'adresse :<BR>
                        <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a></p>
                    </div>
                    <div class="vertical contact-information">
                        <p><b>Par courrier</b><BR>
                        Bébés Lutins - Actypoles<BR>
                        Rue du 19 Mars 1962<BR>
                        63550 THIERS<BR>
                        <em>Nous vous recevons avec plaisir sur rendez-vous.</em></p>
                    </div>
                    <div class="vertical contact-information">
                        <p><b>Par téléphone au service client</b><BR>
                            06 41 56 91 65<BR>
                            <em>Katia répondra avec plaisir à vos questions.</em></p>
                    </div>
                </div>
                <form id="comment_form" action="https://www.bebes-lutins.fr/envoyer-message" class="vertical" method="post">
                    <h2>Formulaire de contact</h2>
                    <?php if(isset($_SESSION['contact-message'])) {echo $_SESSION['contact-message']; unset($_SESSION['contact-message']);}?>
                    <label for="name">Votre nom :</label>
                    <input id='name' name='name' type="text" placeholder="Votre nom et prénom" required>
                    <label for="mail">Votre e-mail :</label>
                    <input id='mail' name='mail' type="email" placeholder="Votre adresse e-mail" required>
                    <label for="subject">Sujet :</label>
                    <input id='subject' name='subject' type="text" placeholder="Le sujet de votre message" required>
                    <label for="message">Message :</label>
                    <textarea id='message' name='message' placeholder="Votre message" required></textarea>
                    <div class="horizontal between" style="margin-top: 10px;">
                        <div class="g-recaptcha" data-sitekey="6Ldj9p4UAAAAAAY_KU7zSzFiAIvfLagBc4WXHaEt"></div>
                        <div id='submit-buttons' class='vertical between'>
                            <button type="submit">Envoyer</button>
                            <button type="submit" form="back-form">Retour</button>
                        </div>
                    </div>
                </form>
                <form id="back-form" action="https://www.bebes-lutins.fr" method="post" class="hidden"></form>
            </div>
        </div>
        <div style="width: 100%; height: 20em;margin-bottom: 2em;border-radius: 10px;" id="map">

        </div>
    </div>
    <div id="static-container" class="vertical mobile">
        <h1>Contactez-nous</h1>
        <div class="static-bloc vertical centered">
            <div class="static-bloc vertical">
                <div class="vertical centered">
                    <div class="vertical">
                        <p><b>Par mail</b><BR>
                            Vous pouvez nous contacter par mail à l'adresse :<BR>
                            <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a></p>
                    </div>
                    <div class="vertical">
                        <p><b>Par courrier</b><BR>
                            Bébés Lutins - Actypoles<BR>
                            Rue du 19 Mars 1962<BR>
                            63550 THIERS<BR>
                            <em>Nous vous recevons avec plaisir sur rendez-vous.</em></p>
                    </div>
                    <div class="vertical">
                        <p><b>Par téléphone au service client</b><BR>
                            06 41 56 91 65<BR>
                            <em>Katia répondra avec plaisir à vos questions.</em></p>
                    </div>
                </div>
                <form action="https://www.bebes-lutins.fr/envoyer-message" class="vertical" method="post">
                    <?php if(isset($_SESSION['contact-message'])) {echo $_SESSION['contact-message']; unset($_SESSION['contact-message']);}?>
                    <label for="name">Votre nom :</label>
                    <input id='name' name='name' type="text" placeholder="Votre nom et prénom" required>
                    <label for="mail">Votre e-mail :</label>
                    <input id='mail' name='mail' type="email" placeholder="Votre adresse e-mail" required>
                    <label for="subject">Sujet :</label>
                    <input id='subject' name='subject' type="text" placeholder="Le sujet de votre message" required>
                    <label for="message">Message :</label>
                    <textarea id='message' name='message' placeholder="Votre message" required></textarea>
                    <div class="horizontal between">
                        <div class="g-recaptcha" data-sitekey="6Ldj9p4UAAAAAAY_KU7zSzFiAIvfLagBc4WXHaEt"></div>
                            <button type="submit" form="back-form">Retour</button>
                            <button type="submit">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>
    function initMap() {
        var uluru = {lat: 45.844297, lng: 3.524763};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5Pnw_Hl2G8f5ETGsTWRhX6bjC1HMz8QI&callback=initMap">
</script>
</html>