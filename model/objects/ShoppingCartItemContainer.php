<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 26/11/2018
 * Time: 11:34
 */

class ShoppingCartItemContainer
{
    private $shopping_cart_item;

    /**
     * ShoppingCartItemContainer constructor.
     * @param $shopping_cart_item
     */
    public function __construct(ShoppingCartItem $shopping_cart_item)
    {
        $this->shopping_cart_item = $shopping_cart_item;
    }

    /**
     * @return ShoppingCartItem
     */
    public function getShoppingCartItem(): ShoppingCartItem
    {
        return $this->shopping_cart_item;
    }

    /**
     * @param ShoppingCartItem $shopping_cart_item
     */
    public function setShoppingCartItem(ShoppingCartItem $shopping_cart_item): void
    {
        $this->shopping_cart_item = $shopping_cart_item;
    }

}