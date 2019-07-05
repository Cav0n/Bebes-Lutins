<?php


class BirthListItemContainer
{
    private $birthlist_item;

    /**
     * BirthListItemContainer constructor.
     * @param $birthlist_item
     */
    public function __construct(BirthListItem $birthlist_item)
    {
        $this->birthlist_item = $birthlist_item;
    }

    /**
     * @return BirthListItem
     */
    public function getBirthlistItem(): BirthListItem
    {
        return $this->birthlist_item;
    }

    /**
     * @param BirthListItem $birthlist_item
     */
    public function setBirthlistItem(BirthListItem $birthlist_item): void
    {
        $this->birthlist_item = $birthlist_item;
    }
}