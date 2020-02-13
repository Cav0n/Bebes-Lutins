<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-03-19
 * Time: 10:26
 */
if(isset($_SESSION['step_shopping_cart'])) $current_step = $_SESSION['step_shopping_cart'];
else $current_step = 1;
?>

<?php if(isset($_SESSION['connected_user'])){?>
    <div id="checkout-stepper-wrapper">
        <ul class="checkout-stepper horizontal">
            <li class="checkout-step <?php if ($current_step >= 1) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                    <span class="checkout-step-number">
                        <?php if ($current_step >= 2)
                            echo "<i class=\"fas fa-check\"></i>";
                        else echo "1";?>
                    </span>
                    <span class="checkout-step-name">
                        Panier
                    </span>
                </div>
            </li>
            <li class="checkout-step <?php if ($current_step >= 2) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                    <span class="checkout-step-number">
                        <?php if ($current_step >= 3)
                            echo "<i class=\"fas fa-check\"></i>";
                        else echo "2";?>
                    </span>
                    <span class="checkout-step-name">
                        Livraison
                    </span>
                </div>
            </li>
            <li class="checkout-step <?php if ($current_step >= 3) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                    <span class="checkout-step-number">
                        <?php if ($current_step >= 4)
                            echo "<i class=\"fas fa-check\"></i>";
                        else  echo "3";?>
                    </span>
                    <span class="checkout-step-name">
                        Paiement
                    </span>
                </div>
            </li>
        </ul>
    </div>
<?php } else { ?>
    <div id="checkout-stepper-wrapper">
        <ul class="checkout-stepper horizontal">
            <li class="checkout-step <?php if ($current_step >= 1) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                <span class="checkout-step-number">
                    <?php if ($current_step >= 2)
                        echo "<i class=\"fas fa-check\"></i>";
                        else echo "1";?>
                </span>
                <span class="checkout-step-name">
                    Panier
                </span>
                </div>
            </li>
            <li class="checkout-step <?php if ($current_step >= 2) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                <span class="checkout-step-number">
                    <?php if ($current_step >= 3)
                        echo "<i class=\"fas fa-check\"></i>";
                        else echo "2";?>
                </span>
                <span class="checkout-step-name">
                    Connexion
                </span>
                </div>
            </li>
            <li class="checkout-step <?php if ($current_step >= 3) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                <span class="checkout-step-number">
                    <?php if ($current_step >= 4)
                        echo "<i class=\"fas fa-check\"></i>";
                        else echo "3";?>
                </span>
                <span class="checkout-step-name">
                    Livraison
                </span>
                </div>
            </li>
            <li class="checkout-step <?php if ($current_step >= 4) echo "checkout-step-current"?>">
                <div class="checkout-step-inner vertical">
                <span class="checkout-step-number">
                    <?php if ($current_step >= 5)
                        echo "<i class=\"fas fa-check\"></i>";
                        else echo "4";?>
                </span>
                <span class="checkout-step-name">
                    Paiement
                </span>
                </div>
            </li>
        </ul>
    </div>
<?php } ?>