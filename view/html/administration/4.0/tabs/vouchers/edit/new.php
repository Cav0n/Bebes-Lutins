<?php

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
    <div class="pre-page-title horizontal between">
        <a href="https://www.bebes-lutins.fr/dashboard4/reductions/"><i class="fas fa-angle-left"></i> Réduction</a>
    </div>
    <div class="page-title-container horizontal between">
        <h2>Créer un code de réduction</h2>
    </div>
    <form id="edition-wrapper" class="horizontal"  action="https://www.bebes-lutins.fr/dashboard4/reductions/sauvegarder/" method="post">
        <div class="column-big vertical">
            <div class="code-name-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Code</p>
                    <a onclick="makeid(10)">Générer un code</a>
                </div>
                <div class="code vertical">
                    <input id="code" type="text" name="name" placeholder="par ex. SOLDESPRINTEMPS">
                    <label class="help" for="code">Les clients saisiront ce code promotionnel lors de leur passage à la caisse.</label>
                </div>
            </div>
            <div class="code-options-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Options</p>
                </div>
                <div class="horizontal">
                    <div class="type vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="type">Type de réduction</label>
                        <select id="type" name="type">
                            <option value="1">Pourcentage</option>
                            <option value="2">Montant fixe</option>
                            <option value="3">Livraison gratuite</option>
                        </select>
                    </div>
                    <div id="value-container" class="value vertical" style="width: 100%;">
                        <label for="value">Valeur de la réduction</label>
                        <input id="value" type="number" name="discount">
                    </div>
                </div>
            </div>
            <div class="code-dates-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Dates d'activités</p>
                </div>
                <div id="beginning-date-container" class="horizontal">
                    <div class="beginning-date vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="beginning-date">Date de début</label>
                        <input id="beginning-date" type="date" name="date_beginning">
                    </div>
                    <div class="beginning-date-hour vertical" style="width: 100%;">
                        <label for="beginning-date-hour">Heure de début</label>
                        <input id="beginning-date-hour" type="time" name="time_beginning">
                    </div>
                </div>
                <div id="end-date-container" class="horizontal">
                    <div class="end-date vertical" style="width: 100%;margin-right: 1rem;">
                        <label for="end-date">Date de fin</label>
                        <input id="end-date" type="date" name="date_end">
                    </div>
                    <div class="end-date-hour vertical" style="width: 100%;">
                        <label for="end-date-hour">Heure de fin</label>
                        <input id="end-date-hour" type="time" name="time_end">
                    </div>
                </div>
            </div>
        </div>
        <div class="column-tiny vertical">
            <div class="code-summary-container edition-window">
                <div class="container-title horizontal between">
                    <p class="section-title">Résumé</p>
                </div>
                <div class="summary vertical">
                    <label class="help">Aucune information saisie.</label>
                </div>
                <div class="container-title horizontal between" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #cccccc;">
                    <p class="section-title">Performance</p>
                </div>
                <div class="summary vertical">
                    <label class="help">La réduction n'est pas active.</label>
                </div>
            </div>
        </div>
    </form>
</main>
</body>
<script>
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        $('#code').val(result.toUpperCase());

        return result;
    }
</script>
</html>

<script>  
$(document).ready(function(){
    $('#type').on('change', function() {
      if ( this.value == '3')
      {
        $("#value-container").hide();
        $("#value").attr('required', false);
      }
      else
      {
        $("#value-container").show();
        $("#value").attr('required', true);
      }
    });
});
</script>