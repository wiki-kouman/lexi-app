<?php

namespace App\Models;

class Category
{
   public function __construct(
       public string $code,
       public string $language,
       public string $wikiText){
   }
}
