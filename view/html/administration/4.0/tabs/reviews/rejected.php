<?php

$declined_reviews = ReviewGateway::GetAllDeclinedReview();

?>

<!DOCTYPE html>
<html style="background: #3b3f4d;" lang="fr">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="dashboard4">
<?php AdminModel::load_administration4_header(); ?>
<main>
    <div class="page-title-container horizontal between">
        <h2>Avis</h2>
    </div>
    <div class="window">
        <div class="window-header">
            <div class="window-tabs">
                <a href="https://www.bebes-lutins.fr/dashboard4/avis/tous-les-avis/acceptes" class="tab vertical centered">Avis acceptés</a>
                <a href="https://www.bebes-lutins.fr/dashboard4/avis/tous-les-avis/rejetes" class="tab vertical centered selected">Avis rejetés</a>
            </div>
        </div>
        <div class="window-inner">
            <div class="search-container">
                <div class="search-input-container">
                    <label for="search-text" class="hidden">Rechercher : </label>
                    <input id="search-text" type="text" name="search-text" placeholder="Rechercher un client">
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th class="customer center">Client</th>
                        <th class="product left">Produit</th>
                        <th class="review left">Commentaire</th>
                        <th class="mark right">Note</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($declined_reviews as $review) { $review = ReviewContainer::GetReview($review);
                        ?>
                        <tr>
                            <td class="customer center"><a href="https://www.bebes-lutins.fr/dashboard/page-client/<?php echo $order->getCustomer()->getId(); ?>"><?php echo ucfirst($order->getCustomer()->getFirstname()) . " " . strtoupper($order->getCustomer()->getSurname()); ?></a></td>
                            <td class="product left"><a href="https://www.bebes-lutins.fr/dashboard4/produit/edition/<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></a></td>
                            <td class="review left"><?php echo $review->getText(); ?></td>
                            <td class="mark right"><?php echo $review->getMark(); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
</html>