<?php

namespace App\Models;

class Definition
{
    public function __construct(
        public string $term,
        public string $label,
        public ?string $translation,
        public string $categoryCode,
        public string $languageCode,
        public array $examples
    ){
    }



}
