<?php
namespace App\Model;

use App\Entity\Categories;

class Filter
{

    /**
     * @var string
     */
    private $keyWord;
    /**
     * @var Categories
     */
    private $categories;

    /**
     * @return string
     */
    public function getKeyWord(): ?string
    {
        return $this->keyWord;
    }

    /**
     * @param string $keyWord
     */
    public function setKeyWord(string $keyWord): void
    {
        $this->keyWord = $keyWord;
    }

    /**
     * @return Categories
     */
    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    /**
     * @param Categories $categories
     */
    public function setCategories(Categories $categories): void
    {
        $this->categories = $categories;
    }




}


