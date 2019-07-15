<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 21:14
 */

if(isset($_SESSION['connected_user'])){
    $user_container = new UserContainer(unserialize($_SESSION['connected_user']));
    $user = $user_container->getUser();
    if($user->getPrivilege() >= 3){
        $admin_button = "<a href='https://www.bebes-lutins.fr/dashboard4' class='no-decoration social-link horizontal'> " . file_get_contents('https://www.bebes-lutins.fr/view/assets/images/utils/icons/edit.svg') . "<p class='social-media-name vertical centered'> - Dashboard</p></a>";
    }
    else $admin_button = "";
} else $admin_button = "";
?>

<p id="copyright">© Bébés Lutins 2018</p>
<div id="links" class="horizontal centered wrap">
    <div class="vertical top">
        <p class="big">Infos pratiques</p>
        <a href="https://www.bebes-lutins.fr/infos-pratiques/livraison-et-frais-de-port">Livraison et frais de port</a>
        <a href="https://www.bebes-lutins.fr/infos-pratiques/paiement">Paiement</a>
        <a href="https://www.bebes-lutins.fr/infos-pratiques/echanges-et-retours">Echanges et retours</a>
        <a href="https://www.bebes-lutins.fr/infos-pratiques/mentions-legales">Mentions légales</a>
        <a href="https://www.bebes-lutins.fr/infos-pratiques/conditions-de-ventes">Conditions de ventes</a>
        <a>Plan du site</a>
    </div>
    <div class="vertical top">
        <p class="big">Nous contacter</p>
        <a href="https://www.bebes-lutins.fr/contact"><i class="fas fa-phone"></i> - Par téléphone</a>
        <a href="https://www.bebes-lutins.fr/contact"><i class="far fa-envelope"></i> - Par mail</a>
        <a href="https://www.bebes-lutins.fr/contact"><i class="fas fa-file-invoice"></i> - Formulaire de contact</a>
        <BR>
        <p class="medium">Katia répondra avec plaisir à vos questions.</p>
    </div>
    <div class="vertical top">
        <p class="big">Nous suivre</p>
        <a href='https://www.instagram.com/bebeslutins/' class="no-decoration social-link horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/instagram.svg"); ?> <p class='social-media-name vertical centered'> - Instagram</p></a>
        <a href='https://www.facebook.com/bebes.lutins/' class="no-decoration social-link horizontal"><?php echo file_get_contents("view/assets/images/utils/icons/facebook.svg"); ?> <p class='social-media-name vertical centered'> - Facebook</p></a>
        <?php echo $admin_button;?>
    </div>
    <div class="vertical top">
        <p class="big">En savoir plus</p>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/qui-sommes-nous">Qui sommes nous ? Fabrication Française</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/pourquoi-les-couches-lavables">Pourquoi les couches lavables ?</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/entretien-des-couches-lavables">Entretien des couches lavables</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/mode-emploi-couches-lavables">Mode d'emploi des couches lavables</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/comment-equiper">Comment s'équiper ?</a>
        <a href="https://www.bebes-lutins.fr/en-savoir-plus/points-de-vente">Points de vente</a>
    </div>
</div>