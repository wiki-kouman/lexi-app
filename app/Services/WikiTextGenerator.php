<?php

namespace App\Services;

use function PHPUnit\Framework\isEmpty;

class WikiTextGenerator {
    private string $DEFAULT_LANGUAGE_CODE = 'fr';
    private string $CONV_LANGUAGE_CODE = 'conv';
    public function wordToWikiText(string $label, string $translation, string $grammarCategory, string $langCode, array $exampleLabels, array $exampleTranslations): string {
        $categoryCode = $this->mapGrammarCategoryToTranslation($grammarCategory);
        $wikiText = "=== {{S|$categoryCode|$langCode}} ===" . "\r\n";
        $wikiText .= "'''$label''' {{pron||$langCode}}" . "\r\n";
        $wikiText .= "# ". $this->sentenceFormat($translation) . "\r\n";

        for ($i = 0; $i < count($exampleLabels); $i++) {
            $examplelabel = $this->sentenceFormat($exampleLabels[$i]);
            $exampleTranslation = $this->sentenceFormat($exampleTranslations[$i]);
            $wikiText .= "#* {{exemple |$examplelabel |sens=$exampleTranslation |lang=$langCode}}" . "\r\n";
        }

        return $wikiText;
    }

    public function languageToWikiText(string $langCode): string {
        $wikiText = "== {{langue|$langCode}} ==" . "\r\n";
        $wikiText .= "=== {{S|étymologie}} ===" . "\r\n";
        $wikiText .= ": {{ébauche-étym|$langCode}}" . "\r\n". "\r\n";
        return $wikiText;
    }

    public function addWikiCategory(string $langCode): string {
        $wikiCategory = $this->mapLangCodeToWikiCategory($langCode);
        return "[[$wikiCategory]]". "\r\n";
    }


    private function mapLangCodeToWikiCategory(string $langCode): string {
        return match($langCode)  {
            'adj' => "Catégorie:adioukrou",
            'any' => "Catégorie:agni de Côte d’Ivoire",
            'bci' => "Catégorie:baoulé",
            'bété' => "Catégorie:bété (Côte d’Ivoire)",
            'default' => '',
        };
    }

    public function mapGrammarCategoryToTranslation(string $grammarCategory): string {
        return match($grammarCategory)  {
            'noun' => "nom",
            'pronoun' => "prénom",
            'verb' => "verbe",
            'adj' => "adjectif",
            'adv' => "adverbe",
            'interj' => "interjection",
            'default' => $grammarCategory,
        };
    }

    public function sentenceFormat(string $text): string {
        // Enforce capitalization of first character
        $text = $this->mb_ucfirst(trim($text));

        // Add ending full-stop, if missing
        if (!preg_match('/[.?!]$/', $text)) {
            $text .= '.';
        }
        return $text;
    }

    private function mb_ucfirst(string $str, ?string $encoding = null): string {
        return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) . mb_substr($str, 1, null, $encoding);
    }

    /**
     * Insert new language section next to its closest sibling
     * If no closest sibling is found, add it at the top.
     * @param WikiTextParser $parser
     * @param string $langCode
     * @param string $wikiText
     * @return string
     */
    public function appendSection(WikiTextParser $parser, string $langCode, string $wikiText): string
    {
        $newWikiText = $parser->wikitext;
        $closestLangCode = $this->getClosestLanguageCode($parser, $langCode);
        $closestLangWikitext = $this->getClosestLanguageWikitext($closestLangCode, $newWikiText);

        if( !empty($closestLangWikitext)) {
            $regexPattern = "/^==?.*(langue)(?:(?!^\n?.*(langue))[\S\s])*$/m";
            preg_match_all($regexPattern, $newWikiText, $matches);
            $insertion_index = array_search($closestLangWikitext, $matches[0]);
            $matches[0][$insertion_index] = $closestLangWikitext . "\r\n". "\r\n" . $wikiText;

            // Join sections back into a single string
            $newWikiText = implode("", $matches[0]);
        } else {
            // By default, append it at the end of the text
            $newWikiText = $wikiText . "\r\n". "\r\n" . $newWikiText;
        }

        return $newWikiText;
    }

    public function getClosestLanguageCode(WikiTextParser $parser, string $newlangCode): string {

        $sections = $parser->term->languagesAndCategories;
        // Discard default language codes as they must remain at the top
        unset($sections[$this->DEFAULT_LANGUAGE_CODE]);
        unset($sections[$this->CONV_LANGUAGE_CODE]);
        $sections = array_keys($sections);

        // Add langCode to an array and sort it to find out where to append the wikitext
        $closestLangCode = $this->DEFAULT_LANGUAGE_CODE;
        $sections[] = $newlangCode;
        sort($sections);
        $currentIndex = array_search($newlangCode, $sections);


        if ($currentIndex > 0 ){
            $closestLangCode = $sections[$currentIndex -1];
        }

        return $closestLangCode;
    }

    private function getClosestLanguageWikitext(string $langCode, $wikiText): string
    {
        $regexPattern = "/^==?.*(langue\|$langCode)(?:(?!^\n?.*(langue))[\S\s])*$/m";
        preg_match($regexPattern, $wikiText, $matches);

        if (count($matches) > 0) {
            return $matches[0];
        }
        return "";
    }
}
