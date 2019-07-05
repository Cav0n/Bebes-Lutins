<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 18/12/2018
 * Time: 15:25
 */

?>

<!DOCTYPE html>
<html>
<head>
    <title>Guide et conseils - Bebes Lutins</title>
    <meta name="description" content="Vous ne savez pas trop comment bien démarrer avec les couches lavables ? Laissez vous guider par l'équipe Bébés Lutins."/>
    <?php UtilsModel::load_head();?>
</head>
<body>
<header>
    <?php UtilsModel::load_header();?>
</header>
<main>
    <div id="static-container">
        <h1>Guide et conseils</h1>
        <div class="static-bloc vertical">
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
                    <h2>Couche + culotte</h2>
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
                    <H2>Taille de la Papillon</H2>
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
        <div class="static-bloc">
            <h2>Pourquoi les couches lavables ?</h2>
            <p>La réduction des déchets est devenue une priorité dans notre société de consommation. Or les couches jetables représentent un énorme gâchis pour l’environnement ! Bébés Lutins vous propose de réduire les déchets liés aux changes de bébé.</p>
        </div>
        <div class="static-bloc">
            <h2>Le saviez-vous ?</h2>
            <p>Pendant les 2 ans et demi en moyenne qu’il faut à un enfant pour acquérir la propreté, les quelques 5000 couches jetées aux ordures ménagères représentent plus d’une tonne de déchets, soit un volume de 30 m<sup>3</sup> ! (l’équivalent d’une chambre de bébé).
                Déchets qui seront incinérés ou enfouis et qui mettront plus de 300 ans pour se décomposer !
                Bébés Lutins vous propose des couches saines et confortables pour bébé, confectionnées dans notre atelier.<BR>
                Sachez aussi qu’en utilisant les couches lavables, vous réduisez la consommation d’eau, d’électricité, et de bois. Vous œuvrez ainsi pour le respect de la biodiversité !
                Envie de vous y mettre ? Rendez-vous dans notre rubrique « comment s’équiper ».
            </p>
        </div>
        <div class="static-bloc-images">

        </div>
        <h1>Entretien des couches lavables</h1>
        <div class="static-bloc">
            <h2>Avant la première utilisation</h2>
            <p>Il est recommandé de laisser tremper vos couches neuves pendant une douzaine d’heures dans de l’eau froide afin de faire gonfler les fibres, de bien  les débarrasser de l’apprêt de tissage et  les rendre plus absorbantes. Ne vous inquiétez pas si des traces de couleurs apparaissent, nous dessinons nos patrons avec des feutres non toxiques et lavables, dès le premier lavage tout sera parti.<BR>
                Il faut savoir qu’elles n’atteindront leur absorption maximale qu’après une dizaine de lavages (comme c’est le cas pour les serviettes de bain par exemple). Il est donc conseillé de laver 2 fois vos couches avant leur première utilisation et de changer votre enfant un peu plus fréquemment au début.
            </p>
        </div>
        <div class="static-bloc">
            <h2>Stockage des couches souillées</h2>
            <p>« <b>Stockage à sec</b> » c'est-à-dire : Après utilisation, les couches seront stockées dans un seau, sans eau, avec un couvercle.<BR>
                Vous pouvez pulvériser notre « spray  Néobulle » spécial couches, directement dans le seau ou sur la couche, les huiles essentielles sont diluées et donc sans danger pour la peau. Attention à ne pas stocker vos couches au-delà de 3 jours au risque de les détériorer.<BR>
                Les huiles essentielles ont des propriétés désinfectantes et désodorisantes.<BR>
                Vous pouvez disposer un filet pour récupérer aisément les couches souillées avant de les mettre dans le lave-linge.<BR>
            </p>

        </div>
        <div class="static-bloc">
            <h2>Les selles</h2>
            <p>Il existe des voiles non-tissés spécifiques, permettant de « récupérer » les selles.<BR>
                Vous en trouverez deux sortes :</p>
            <ul>
                <li><p><strong>Le voile épais</strong> (en rouleau) qui est conseillé pour les selles molles des bébés allaités.</p></li>
                <li><p><strong>Le voile fin</strong> (en boîte) lorsque les selles sont plus compactes.</p></li>
            </ul>
            <p>Ces deux voiles papiers peuvent être lavés au moins 3 fois avec vos couches s’ils sont juste mouillés. Attention risque de passage dans le filtre sur certaines machines, n’hésitez pas à les glisser dans un filet ! Sur les boites il est indiqué que l’on peut les jeter directement dans les toilettes, surtout ne pas le faire pour les fosses septique !  Évitez de le faire trop souvent pour le « tout à l’égout », notamment si les canalisations sont étroites, et préférez la poubelle s’ils sont justes mouillés.<BR>
                Sachez aussi que si vous utilisez des voiles « micro-polaire » qui procurent un effet « bébé au sec », les selles adhèrent peu et il suffit souvent de secouer le voile au-dessus des toilettes avant de le passer au lavage-linge. Cela convient bien lorsque bébé à des selles compactes.<BR></p>

        </div>
        <div class="static-bloc">
            <h2>Le lavage</h2>
            <p>Vous pouvez <strong>laver les couches et culottes de 40°  à  60 °</strong> sans souci, mais préférez un lavage régulier à <b>40 ° pour les culottes de protection</b>. Les <strong>couches classiques</strong>, les enveloppes des « <b>tout en un</b> » et <b>parties absorbantes</b> peuvent quant à elles passer à <b>60 ° régulièrement sans souci.</b><BR>
                <strong>Il ne faut absolument pas utiliser d’adoucissant</strong>, il imperméabilise les couches rapidement et cela engendre rapidement des fuites.<BR>
                De même, <strong>évitez les lessives grasses</strong> (lessives à base de savon de Marseille qui contiennent de la glycérine) elles saturent les couches et les rendent inefficaces.<BR>
                Nous déconseillons les huiles essentielles dans la machine à laver, qui risquent de détériorer les fibres.<BR>
                Il est conseillé d’utiliser des produits d’entretien doux, pour préserver les fesses de bébé ainsi que vos couches (on trouve des lessives sans allergènes et sans phosphates).<BR>
                <b>Nous conseillons</b> vivement <b>les lessives en poudre</b>, ce sont celles qui se rincent le mieux tout en restant les plus efficaces pour l’entretien des couches lavables.<BR>
                Assurez-vous que vos couches soient toujours bien rincées, n’hésitez pas à laver en cycle coton pour éliminer tous résidus de lessive.<BR>
                Les couches classiques ainsi que les pans absorbants des TE1 peuvent passer au sèche-linge sur un cycle délicat.<BR>
                Les culottes en PUL (celles concernant le système couche + culotte de protection) n’ont pas besoin d’être lavées à chaque change. Il suffit de les aérer, c’est pourquoi il est conseillé d’en avoir au moins 3 par taille pour tourner sans souci. Vous pouvez les laver à 40° (60° maximum de temps en temps).<BR>
                <BR>
                Rappel : <em>L’utilisation du sèche-linge est déconseillée pour toutes les parties imperméables, utilisez le cycle délicat si vous passez les éléments absorbants.</em><BR>

            </p>
        </div>
        <div class="static-bloc">
            <h2>IMPORTANT !!</h2>
            <p>De temps en temps, environ une fois par mois, il peut être utile de faire ce que l’on appelle un « Décrassage ».<BR>
                En effet, au fur et à mesure des lavages la couche peut perdre de son pouvoir absorbant, dégager une forte odeur en contact avec l’urine ou provoquer des rougeurs. Si vous avez un de ces symptômes, c’est signe d’encrassage des couches. Les fibres sont probablement saturées en lessive, crème pour le change …<BR>
                Marche à suivre : Une fois les couches lavées normalement avec votre lessive habituelle sur un cycle long à 60°, vous relancez  un cycle sans lessive, de nouveau à 60° et sur cycle long. Ne rien ajouter sur le deuxième cycle (ni huiles essentielles, ni bicarbonate de soude)
                Uniquement en cas de calcaire, ajouter un demi-verre de vinaigre blanc dans le bac à lessive, au moment du décrassage. Dans ce cas, ne faites le cycle avec le vinaigre que tous les deux mois. Le vinaigre utilisé trop fréquemment détériore prématurément les élastiques.<BR>
                <BR>
                <em>N’utilisez jamais de Javel, au risque de détériorer les couches lavables.</em></p>
        </div>
        <h1>Comment s'équiper ?</h1>
        <div class="static-bloc">
            <h2>Les couches Bébés Lutins</h2>
            <p>Bébés Lutins vous propose des couches lavables modernes et pratiques ! Elastiquées à la taille et aux cuisses, fermeture à pressions, les couches lavables Bébés Lutins s’adaptent à la morphologie de bébé. Si certaines couches classiques s’utilisent avec une culotte de protection souple et imperméable, d’autres intégrales « tout en un » sont complètes et se rapprochent de la facilité d’utilisation de couches jetables.</p>
        </div>
        <div class="static-bloc">
            <h2>Combien de couches lavables ?</h2>
            <p>Bébés Lutins vous conseille entre 15 et 20 couches lavables pour un bon roulement avec des machines tous les 2-3 jours.<BR>
                Si vous vous équipez avec des couches classiques nécessitant une culotte de protection, comptez au moins 3 culottes par taille. Celles-ci ne se lavent pas à chaque fois.<BR>
                <BR>
                <i>N’hésitez pas à consulter nos lots pour vous donner une idée.</i></p>
        </div>
        <div class="static-bloc">
            <h2>Question budget ?</h2>
            <p>En plus de réduire vos déchets, vous réduisez vos dépenses !<BR>
                S’équiper pour tourner au quotidien en couches lavables vous coûtera entre 400 et 600 € suivant vos choix.<BR>
                Pour information, les couches jetables que bébé utilisera jusqu’à sa propreté vous coûteront en moyenne 1500 € !<BR>
                Alors même en comptant 300 € d’entretien, lessive, eau, électricité, voiles de protection, vous réduisez tout de même d’un tiers voir de moitié votre budget ! Et bien entendu, pour un deuxième bébé vous économisez encore plus !<BR>
                <BR>
                <i>Pensez aussi « lingettes lavables » ! Pratiques, douces et souples elles se lavent facilement avec le reste de votre linge.</i>
            </p>
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

