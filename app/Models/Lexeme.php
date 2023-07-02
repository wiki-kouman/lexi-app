<?php

namespace App\Models;

class Lexeme
{
    public int $id;
    public string $label;
    public array $categories;

    /**
     * @param string $label
     * @param Category[] $categories
     */
    public function __construct(string $label, array $categories)
    {
        $this->label = $label;
        $this->categories = $categories;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return array
     */
    public function getCategoriesGroupedByLanguages(): array
    {
        $groups = [];
        foreach($this->categories as $category){
            $groups[$category->language->code][] = $category;
        }

        return $groups;
    }

}
