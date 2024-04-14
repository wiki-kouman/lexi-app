<?php

namespace App\Models;

class Term
{
    public array $languagesAndCategories = [];
    public array $definitions = [];

    /**
     * @param string|null $label
     * @param Category[] $categories
     */
    public function __construct(public ?string $label, public ?array $categories)
    {
    }

}
