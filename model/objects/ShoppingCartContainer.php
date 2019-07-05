<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 26/11/2018
 * Time: 10:05
 */

class ShoppingCartContainer
{
    private $shopping_cart;

    /**
     * ShoppingCartContainer constructor.
     * @param $shopping_cart
     */
    public function __construct(ShoppingCart $shopping_cart)
    {
        $this->shopping_cart = $shopping_cart;
    }

    /**
     * @return ShoppingCart
     */
    public function getShoppingCart(): ShoppingCart
    {
        return $this->shopping_cart;
    }

    /**
     * @param ShoppingCart $shopping_cart
     */
    public function setShoppingCart(ShoppingCart $shopping_cart): void
    {
        $this->shopping_cart = $shopping_cart;
    }


}