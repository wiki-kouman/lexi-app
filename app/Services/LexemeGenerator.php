<?php

namespace App\Services;

class LexemeGenerator
{
    public function newPageContent(string $lexeme, string $wikiCategory)
    {
        $wikiText = <<<EOT
        == {{langue|fr}} ==
        {{ébauche|fr}}
        === {{S|étymologie}} ===
        : {{ébauche-étym|fr}}

        $lexeme

        ==== {{S|traductions}} ====
        {{trad-début}}
        {{trad-fin}}

        === {{S|voir aussi}} ===
        * {{WP}}

        $wikiCategory

        EOT;
        return $wikiText;
    }
}
