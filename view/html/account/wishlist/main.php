<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-20
 * Time: 08:49
 */

$user = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
$whishlist = WishListGateway::GetWishListOfUser($user->getId());
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
                <h2>Bonjour <?php echo $user->getFirstname() . " " . $user->getSurname(); ?></h2>
                <p>Bienvenue dans votre espace</p>
            </div>
            <div id="customer-area-tabs" class="horizontal">
                <a href="https://www.bebes-lutins.fr/espace-client">Mon profil</a>
                <a href="https://www.bebes-lutins.fr/espace-client/commandes">Mes commandes</a>
                <a href="https://www.bebes-lutins.fr/espace-client/adresses">Mes adresses</a>
                <a href="https://www.bebes-lutins.fr/espace-client/liste-envie" class='selected'>Liste d'envie</a>
            </div>
        </div>
        <div id="customer-area-inner" class="vertical">
            <div id="wishlist-container">
                <div class='horizontal between'>
                    <H3>MA LISTE D'ENVIE</H3>
                    <div class='vertical centered'>
                        <div class='horizontal'>
                            <a class='title-button'>Partager ma liste</a>
                            <a class='title-button'>Tout ajouter au panier</a>
                            <a class='title-button'>Sauvegarder</a>
                        </div>
                    </div>
                </div>
                <div class="customer-area-bloc horizontal wrap">
                    <?php if(!empty($whishlist->getItems())) { foreach($whishlist->getItems() as $item) { $product = $item->getProduct(); ?>
                        <div class='wishlist-item vertical'>
                            <img src='https://www.bebes-lutins.fr/view/assets/images/produits/<?php echo $product->getImage(); ?>' >
                            <p class='title'><?php echo $product->getName();?></p>
                            <textarea class='wishlist-item-textarea' placeholder='Ce texte est facultatif et vous permet de préciser des choses par rapport au produit.'></textarea>
                            <button class="remove-button" onclick='delete_item_from_wishlist("<?php echo $item->getId(); ?>")'>Enlever de la liste</button>
                            <button class="add-to-cart-button">Ajouter au panier</button>
                        </div>
                    <?php } } else { ?>
                        <p>Votre liste d'envie est vide.</p>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div id="customer-area-mobile" class="mobile vertical centered">
        <H1>Ma liste d'envie</H1>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>
    function delete_item_from_wishlist(id){
        document.location.href='https://www.bebes-lutins.fr/espace-client/liste-envie/supprimer-item/' + id;
    }
</script>
</html>
