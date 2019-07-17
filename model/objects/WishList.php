<?php

class WishList
{
    private $id;
    private $user_id;
    private $message;
    private $items;

    public function __construct(string $id, string $user_id, string $message)
    {
        $this->$id = $id;
        $this->$user_id = $user_id;
        $this->$message = $message;
    }

    /**
     * @return string id L'identifiant de la liste d'envie
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string id L'identifiant de la liste d'envie
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string user_id L'identifiant de l'utilisateur
     */
    public function getUserID(): string
    {
        return $this->user_id;
    }

    /**
     * @param string user_id L'identifiant de l'utilisateur
     */
    public function setUserID(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string message Le message de la liste d'envie
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string message Le message de la liste d'envie
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string items La liste d'item
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param string item La nouvelle liste d'item
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param string item L'item a ajouté
     */
    public function addItems(WishListItem $item): void
    {
        $this->items[] = $item;
    }
}