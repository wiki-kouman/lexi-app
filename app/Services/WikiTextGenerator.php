<?php

namespace App\Services;

class WikiTextGenerator {

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

    public function addNewLanguageSection(string $langCode): string {
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

    public function sentenceFormat(string $text): string
    {
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
}
