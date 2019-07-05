<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 26/11/2018
 * Time: 09:29
 */

class ProductContainer
{
    private $product;

    /**
     * ProductContainer constructor.
     * @param $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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
}