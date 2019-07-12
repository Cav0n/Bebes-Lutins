<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-20
 * Time: 14:53
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();

$user_id = $user->getId();
$firstname = $user->getFirstname();
$surname = $user->getSurname();
$mail = $user->getMail();
$phone_number = $user->getPhone();

$address_list = UserGateway::GetAllAddressForUser($user);
$address_list_bak = $user->getAddressList();

$billing_address_list = array();
$shipping_address_list = array();
foreach ($address_list as $address){
    $address = (new AddressContainer($address))->getAddress();
    $address_id = $address->getId();
    $address_street = $address->getAddressLine();

    if(substr($address_id, 0, 15) != 'withdrawal-shop' ){
        if(strpos($address_id, "-billing")) {
            $billing_address_list[] = $address;
            $billing_street_list[] = $address_street;
        }
        if(strpos($address_id, "-shipping")) {
            $shipping_address_list[] = $address;
            $shipping_steet_list[] = $address_street;
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mes adresses - Bebes Lutins</title>
    <meta name="description" content="Accedez a vos adresses pour les modifier ou les supprimer."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main class="vertical">
    <div id="customer-area2" class="vertical">
        <div id="customer-area-header" class="vertical">
            <div id="hello" class="vertical">
                <h2>Bonjour <?php echo $firstname;?></h2>
                <p>Bienvenue dans votre espace</p>
            </div>
            <div id="customer-area-tabs" class="horizontal">
                <a href="https://www.bebes-lutins.fr/espace-client">Mon profil</a>
                <a href="https://www.bebes-lutins.fr/espace-client/commandes">Mes commandes</a>
                <a href="#" class="selected">Mes adresses</a>
                <a href="https://www.bebes-lutins.fr/espace-client/liste-envie">Liste d'envie</a>
            </div>
        </div>
        <div id="customer-area-inner" class="vertical">
            <?php if(!empty($address_list)){ ?>
                <div class="address-container vertical">
                    <h3>MES ADRESSES</h3>
                    <div class="address-list horizontal">
                        <div class="shipping-address-list vertical">
                            <h4>Adresses de livraison</h4>
                        <?php foreach ($shipping_address_list as $address){
                            $address = (new AddressContainer($address))->getAddress();

                            $address_id = $address->getId();
                            $customer_firstname = $address->getFirstname();
                            $customer_surname = $address->getSurname();
                            $customer_civility = $address->getCivilityString();
                            $address_street = $address->getAddressLine();
                            $address_complement = $address->getComplement();
                            $address_zipcode = $address->getPostalCode();
                            $address_city = $address->getCity();
                            $address_company = $address->getCompany();
                            ?>
                            <div class="address horizontal">
                                <div class="address-summary vertical centered">
                                    <p class="big-city"><?php echo $address_city; ?></p>
                                    <p><?php echo $customer_civility . " " . $customer_firstname . " " . $customer_surname; ?></p>
                                    <?php if($address_company != null) { ?><p><?php echo $address_company; ?></p><?php } ?>
                                    <p><?php echo $address_street; ?></p>
                                    <?php if($address_complement != null) { ?><p><?php echo $address_complement; ?></p><?php } ?>
                                    <p><?php echo $address_zipcode; ?></p>
                                    <p><?php echo $address_city; ?></p>
                                </div>
                                <form method="post" class="address-links vertical centered">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">

                                    <button disabled><i class="fas fa-pencil-alt"></i> Modifier</button>
                                    <button formaction="https://www.bebes-lutins.fr/espace-client/supprimer-addresse"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                </form>
                            </div>
                        <?php } ?>
                        </div>
                        <div class="billing-address-list vertical">
                            <h4>Adresses de facturations</h4>
                        <?php foreach ($billing_address_list as $address){
                            $address = (new AddressContainer($address))->getAddress();

                            $address_id = $address->getId();
                            $customer_firstname = $address->getFirstname();
                            $customer_surname = $address->getSurname();
                            $customer_civility = $address->getCivilityString();
                            $address_street = $address->getAddressLine();
                            $address_complement = $address->getComplement();
                            $address_zipcode = $address->getPostalCode();
                            $address_city = $address->getCity();
                            $address_company = $address->getCompany();
                            ?>
                            <div class="address horizontal">
                                <div class="address-summary vertical centered">
                                    <p class="big-city"><?php echo $address_city; ?></>
                                    <p><?php echo $customer_civility . " " . $customer_firstname . " " . $customer_surname; ?></p>
                                    <?php if($address_company != null) { ?><p><?php echo $address_company; ?></p><?php } ?>
                                    <p><?php echo $address_street; ?></p>
                                    <?php if($address_complement != null) { ?><p><?php echo $address_complement; ?></p><?php } ?>
                                    <p><?php echo $address_zipcode; ?></p>
                                    <p><?php echo $address_city; ?></p>
                                </div>
                                <form method="post" class="address-links vertical centered">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="street" value="<?php echo $address_street; ?>">
                                    <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
                                    <input type="hidden" name="address_type" value="billing">

                                    <button disabled><i class="fas fa-pencil-alt"></i> Modifier</button>
                                    <button formaction="https://www.bebes-lutins.fr/espace-client/supprimer-addresse"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                </form>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <p style="text-align: center;">Vous n'avez encore aucune adresse sauvegardée.</p>
            <?php }?>
        </div>
    </div>
</main>
<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
</html>