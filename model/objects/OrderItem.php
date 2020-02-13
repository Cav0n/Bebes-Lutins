<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 22/11/2018
 * Time: 09:59
 */

class OrderItem
{
    private $id;
    private $product;
    private $quantity;
    private $unit_price;

    /**
     * OrderItem constructor.
     * @param $id
     * @param $product
     * @param $quantity
     * @param $unit_price
     */
    public function __construct(String $id, Product $product, int $quantity, float $unit_price)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
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
    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    /**
     * @param float $unit_price
     */
    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }
}