<?php

/* Verification of current tab */
if(isset($_GET['header_tab'])) $selection_tab_header = $_GET['header_tab'];
else $selection_tab_header = "orders";
if(isset($_SESSION['header_tab'])) $selection_tab_header = $_SESSION['header_tab'];
unset($_SESSION['header_tab']);

if (isset($_SESSION['connected_user'])){
    $administrator = (new UserContainer(unserialize($_SESSION['connected_user'])))->getUser();
}

$notifications = NotificationGateway::GetNumberOfNewNotifications();
if($notifications['new_orders'] > 0) $new_orders_number = "(".$notifications['new_orders'].")";
else {$new_orders_number = "";}

if($notifications['new_users'] > 0) $new_users_number = "(".$notifications['new_users'].")";
else {$new_users_number = "";}

if($notifications['new_reviews'] > 0) $new_reviews_number = "(".$notifications['new_reviews'].")";
else {$new_reviews_number = "";}
?>

<header>
    <a href="https://www.bebes-lutins.fr" class="no-decoration"><h1>BEBES LUTINS</h1></a>
    <div id="header-tabs" class="tabs">
        <button id="orders" class="header-button <?php if($selection_tab_header != 'orders') echo 'non-';?>selected" onclick="tab_selection_changed_header('orders')">
            <div class="horizontal tab">
                <i class="fas fa-boxes fa-2x"></i>
                <p>Commandes <?php echo $new_orders_number; ?></p>
            </div>
        </button>
        <button id="reviews" class="header-button <?php if($selection_tab_header != 'reviews') echo 'non-'?>selected" onclick="tab_selection_changed_header('reviews')">
            <div class="horizontal tab">
                <i class="far fa-star fa-2x"></i>
                <p>Avis clients <?php echo $new_reviews_number; ?></p>
            </div>
        </button>
        <button id="products" class="header-button <?php if($selection_tab_header != 'products') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('products')">
            <div class="horizontal tab">
                <i class="fas fa-sitemap fa-2x"></i>
                <p>Produits</p>
            </div>
        </button>
        <button id="users" class="header-button <?php if($selection_tab_header != 'users') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('users')">
            <div class="horizontal tab">
                <i class="fas fa-users fa-2x"></i>
                <p>Utilisateurs <?php echo $new_users_number; ?></p>
            </div>
        </button>
        <button id="various" class="header-button <?php if($selection_tab_header != 'various') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('various')">
            <div class="horizontal tab">
                <i class="fas fa-chart-line fa-2x"></i>
                <p>Divers</p>
            </div>
        </button>
        <button id="search" class="header-button <?php if($selection_tab_header != 'search') echo 'non-';?>selected <?php if($administrator->getPrivilege() < 4) echo 'hidden'?>" onclick="tab_selection_changed_header('search')">
            <div class="horizontal tab">
                <i class="fas fa-search fa-2x"></i>
                <p>Recherche</p>
            </div>
        </button>
    </div>
    <div id="dashboard-version">
        <p>Version : 3.3</p>
    </div>

    <script>
        function tab_selection_changed_header(new_selected_id){
            document.location.href="https://www.bebes-lutins.fr/dashboard/tab/"+new_selected_id;
        }
    </script>
</header>
