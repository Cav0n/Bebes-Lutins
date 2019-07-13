<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 10/12/2018
 * Time: 10:53
 */

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mode d'emploi des couches lavables - Bebes Lutins</title>
    <meta name="description" content="Vous ne savez pas comment utilisez les couches lavables Bébés Lutins ? Ne vous inquiétez pas, nous avons crée un mode d'emploi."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="static-container">
        <h1>Mode d'emploi des couches lavables</h1>
        <div class="desktop static-bloc vertical">
            <div id='manual-tab' class="horizontal centered">
                <p id='colombine' class="selected" onclick="tab_selection_changed_orders('colombine')">Système "TE1-TE2" Colombine</p>
                <p id='couche-culotte' class="non-selected" onclick="tab_selection_changed_orders('couche-culotte')">Système couche + culotte</p>
                <p id='taille-papillon' class="non-selected" onclick="tab_selection_changed_orders('taille-papillon')">Réglage de la taille de la Papillon</p>
            </div>
            <div id="manual-display" class="vertical">
                <div id="display-colombine" class="display-manual vertical selected">
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/1.png" title="Réglage de la taille" alt="Ajustement de la taille">
                        <p>Réglage de la taille suivant le poids de bébé</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/2.png" title="Grand pan absorbant" alt="Fixation du grand pan absorbant">
                        <p>Fixer le grand pan absorbant à l'aide des deux pressions à l'avant de la couche. Ajouter le petit pan si besoin.</p>
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/3-1.png" title="Points de fixation" alt="Points de fixation du voile de protection jetable">
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/3.png" title="Voile de protection jetable" alt="Voile de protection jetable">
                        <p>Placer le voile de protection jetable au fond de la couche</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/4.png" title="Colombine bleue a refermer" alt="Colombine bleue">
                        <p>On installe la couche sur bébé, on referme, c'est aussi simple que ça !</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Colombine/5.png" title="Colombine bleue fermée" alt="Colombine bleue fermée">
                        <p>On vérifie autour des cuisses et dans le dos, le voile de protection et le tissu absorbant ne doivent pas dépasser.</p>
                    </div>
                </div>

                <div id="display-couche-culotte" class="display-manual vertical non-selected">
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Couche_culotte/1.png" title="" alt="">
                        <p>Positionner le voile de protection jetable au fond de la couche.</p>
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Couche_culotte/1-1.png" title="" alt="">
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Couche_culotte/2.png" title="" alt="">
                        <p>Installer la couche classique sur bébé.</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Couche_culotte/3.png" title="" alt="">
                        <p>Puis installer la culotte de protection indispensable pour les couches classiques.</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Couche_culotte/4.png" title="" alt="">
                        <p>On vérifie autour des cuisses et dans le dos, la couche classique ne doit pas dépasser.<BR>Et le biais élastique doit être juste posé sans trop serrer. </p>
                    </div>
                </div>

                <div id="display-taille-papillon" class="display-manual vertical non-selected">
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/1.png" title="" alt="">
                        <p>Placer la doublure au fond de la couche si besoin (nuit par exemple).<BR>Puis positionner le voile de protection jetable au fond de la couche.</p>
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/3.png" title="" alt="">
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/2.png" title="" alt="">
                        <p>Réglage de la taille suivant le poids de bébé.<BR>(A gauche : petit et moyen)<BR>(A droite : grand)</p>
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/2-1.png" title="" alt="">
                    </div>
                    <div class="manual-text horizontal centered">
                        <p>On installe la couche sur bébé, on referme, c'est aussi simple que ça !</p>
                    </div>
                    <div class="manual-text horizontal centered">
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/4.png" title="" alt="">
                        <p>On vérifie autour des cuisses et dans le dos, le voile de protection ne doit pas dépasser.</p>
                        <img src="https://www.bebes-lutins.fr/view/assets/images/utils/manual/Taille_papillon/4-1.png" title="" alt="">
                    </div>
                    <div class="manual-text horizontal centered">
                        <p>Et on n'oublie pas d'ajouter la culotte de protection imperméable :-).</p>
                    </div>
                </div>
            </div>
        </div>

        <H1 class="desktop">En image</H1>

        <div class="static-bloc horizontal centered wrap">
            <a href="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-Colombine.jpg" target="_blank">
                <img class='manual-image' src="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-Colombine.jpg" width="310" height="438">
            </a>
            <a href="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-CoucheCulotte.jpg" target="_blank">
                <img class='manual-image' src="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-CoucheCulotte.jpg" width="310" height="438">
            </a>
            <a href="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-Papillon.jpg" target="_blank">
                <img class='manual-image' src="https://www.bebes-lutins.fr/view/assets/images/utils/Mode-Emploi-Papillon.jpg" width="310" height="438">
            </a>
        </div>
        <div class="static-bloc horizontal centered">
            <p style="margin: 0;">Cliquez sur les images pour les agrandir.</p>
        </div>
        <div class="static-bloc-images">

        </div>
    </div>
</main>

<footer>
    <?php UtilsModel::load_footer();?>
</footer>
</body>
<script>
    function tab_selection_changed_orders(new_selected_id){
        var children_tab = Array.from(document.getElementById("manual-tab").children);
        children_tab.forEach(function (entry) {
            entry.setAttribute("class", "non-selected");
        });
        $("#"+new_selected_id).removeClass("non-selected").addClass("selected");

        var children_display = Array.from(document.getElementById("manual-display").children);
        children_display.forEach(function (entry) {
            entry.setAttribute("class", "non-selected display-manual vertical");
        });
        $("#display-"+new_selected_id).removeClass("non-selected").addClass("selected");
    }
</script>
</html>
