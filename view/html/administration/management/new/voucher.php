<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 13/12/2018
 * Time: 13:41
 */
?>

<!DOCTYPE html>
<html style="background: #3b3f4d;">
<head>
    <title>ADMINISTRATION - BEBES LUTINS</title>
    <meta name="description" content="Bienvenue dans votre tout nouveau tableau de bord."/>
    <?php UtilsModel::load_head();?>
</head>
<body id="administration">
<header>
    <a href="https://www.bebes-lutins.fr" class="no-decoration"><h1>BEBES LUTINS</h1></a>
    <div id="header-tabs" class="tabs">
        <button id="orders" class="header-button <?php if($selection_tab_header != 'orders') echo 'non-';?>selected" onclick="tab_selection_changed_header('orders')">
            <div class="horizontal tab">
                <i class="fas fa-boxes fa-2x"></i>
                <p>Commandes</p>
            </div>
        </button>
        <button id="products" class="header-button <?php if($selection_tab_header != 'products') echo 'non-';?>selected" onclick="tab_selection_changed_header('products')">
            <div class="horizontal tab">
                <i class="fas fa-sitemap fa-2x"></i>
                <p>Produits</p>
            </div>
        </button>
        <button id="users" class="header-button <?php if($selection_tab_header != 'users') echo 'non-';?>selected" onclick="tab_selection_changed_header('users')">
            <div class="horizontal tab">
                <i class="fas fa-users fa-2x"></i>
                <p>Utilisateurs</p>
            </div>
        </button>
        <button id="various" class="header-button <?php if($selection_tab_header != 'various') echo 'non-';?>selected" onclick="tab_selection_changed_header('various')">
            <div class="horizontal tab">
                <i class="fas fa-chart-line fa-2x"></i>
                <p>Divers</p>
            </div>
        </button>
    </div>
</header>
<main>
    <div id="options">

    </div>
    <div id="voucher-add-wrapper" class="vertical">
        <h1>Création d'un code coupon</h1>
        <form class="voucher-add-form vertical" method="post" action="https://www.bebes-lutins.fr/dashboard/creation-code-coupon-do" enctype="multipart/form-data">
            <label for="voucher-name">Nom : </label>
            <input id='voucher-name' type="text" name="name" placeholder="Nom du coupon" required>
            <div class="horizontal">
                <div id="select-type-container" class="vertical">
                    <label for="select-type">Type : </label>
                    <select id="select-type" name="type"  onchange="hide_reduction(this.value)" required>
                        <option value="1">%</option>
                        <option value="2">€</option>
                        <option value="3">frais de port</option>
                    </select>
                </div>
                <div id="discount-number" class="vertical display">
                    <label for="discount-input">Réduction : </label>
                    <input type="number" name="discount" placeholder="La réduction offerte" id="discount-input" step="0.01" min="0.01" required>
                </div>
            </div>
            <label for="number-of-usage-input">Nombre d'utilisation : </label>
            <input id="number-of-usage-input" type="number" name="number_of_usage" placeholder="Nombre maximum d'utilisation par personne" step="1" min="1" required>
            <div class="horizontal">
                <div class="vertical">
                    <label for="date-beginning-input">Date de début : </label>
                    <input id="date-beginning-input" type="date" name="date_beginning" required>
                </div>
                <div class="vertical">
                    <label for="date-end-input">Date de fin : </label>
                    <input id="date-end-input" type="date" name="date_end" required>
                </div>
            </div>
            <div id="voucher-add-button" class="horizontal centered">
                <button type="submit">Ajouter le coupon</button>
            </div>
        </form>
    </div>
</main>
</body>
<script>
    function hide_reduction(val){
        if(val == '3'){
            $("#discount-number").removeClass("display").addClass("hidden").val(0);
            document.getElementById("discount-input").value = 0;
            $("#discount-input").attr('max', '').attr('min', "").attr('step', "");
            document.getElementById("discount-input").removeAttribute("required");
        }
        else if(val == '1'){
            $("#discount-number").removeClass("hidden").addClass("display").val(0);
            $("#discount-input").attr('max', 100).attr('min', 0).attr('step', 1);
            document.getElementById("discount-input").value = 0;
            document.getElementById("discount-input").setAttribute("required", "required");
        }
        else if(val =='2'){
            $("#discount-number").removeClass("hidden").addClass("display").val(0);
            $("#discount-input").attr('max', '').attr('min', 0.01).attr('step', 0.01);
            document.getElementById("discount-input").value = 0;
            document.getElementById("discount-input").setAttribute("required", "required");
        }
    }

    function tab_selection_changed_header(new_selected_id){
        document.location.href="https://www.bebes-lutins.fr/dashboard/tab-"+new_selected_id;
    }
</script>
</html>
