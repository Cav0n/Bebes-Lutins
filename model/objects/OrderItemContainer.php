<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 28/11/2018
 * Time: 08:48
 */

class OrderItemContainer
{
    private $orderitem;

    /**
     * OrderItemContainer constructor.
     * @param $orderitem
     */
    public function __construct(OrderItem $orderitem)
    {
        $this->orderitem = $orderitem;
    }

    /**
     * @return OrderItem
     */
    public function getOrderitem(): OrderItem
    {
        return $this->orderitem;
    }

    /**
     * @param OrderItem $orderitem
     */
    public function setOrderitem(OrderItem $orderitem): void
    {
        $this->orderitem = $orderitem;
    }
}