<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:06
 */

class User
{
    private $id;
    private $shopping_cart;

    /**
     * User constructor.
     * @param $id
     * @param $shopping_cart
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getId(): String
    {
        return $this->id;
    }

    /**
     * @param String $id
     */
    public function setId(String $id): void
    {
        $this->id = $id;
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