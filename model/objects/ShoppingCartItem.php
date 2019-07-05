<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 15:50
 */

class ShoppingCartItem
{
    private $id;
    private $shopping_cart;
    private $product;
    private $quantity;
    private $price;

    /**
     * ShoppingCartItem constructor.
     * @param $id
     * @param $shopping_cart
     * @param $product
     * @param $quantity
     * @param $price
     */
    public function __construct(String $id, Product $product, int $quantity, float $price)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
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

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }


}