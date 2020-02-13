<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 27/11/2018
 * Time: 15:56
 */

class OrderContainer
{
    private $order;

    /**
     * OrderContainer constructor.
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }
}