<?php

class WishListItem
{
    private $id;
    private $wishlist_id;
    private $product_id;
    private $message;

    public function __construct($id, $wishlist_id, $product_id,$message)
    {
        $this->id = $id;
        $this->wishlist_id = $wishlist_id;
        $this->product_id = $product_id;
        $this->message = $message;
    }

    /**
     * @return string id L'identifiant de l'item dans la liste
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string id L'identifiant de l'item dans la liste
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string id L'identifiant de la liste d'envie
     */
    public function getWishListID(): string
    {
        return $this->wishlist_id;
    }

    /**
     * @param string id L'identifiant de la liste d'envie
     */
    public function setWishListID(string $wishlist_id): void
    {
        $this->wishlist_id = $wishlist_id;
    }

    /**
     * @return string id L'identifiant du produit correspondant
     */
    public function getProductID(): string
    {
        return $this->product_id;
    }

    /**
     * @param string id L'identifiant du produit correspondant
     */
    public function setProductID(string $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return string message Le message lié à l'item
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string message Le message lié à l'item
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}