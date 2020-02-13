<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 04/12/2018
 * Time: 09:36
 */

class CategoryContainer
{
    private $category;

    /**
     * CategoryContainer constructor.
     * @param $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}