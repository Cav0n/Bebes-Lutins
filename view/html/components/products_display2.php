<?php 

$sorted_price = $REQUEST['sorted_price'];
if($sorted_price == null) $sorted_price = false;

$products = ProductGateway::GetProducts2();

?>