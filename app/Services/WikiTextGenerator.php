<?php

namespace App\Services;

class WikiTextGenerator {

    public function wordToWikiText(string $label, string $translation, string $grammarCategory, string $langCode, array $exampleLabels, array $exampleTranslations): string {
        $categoryCode = $this->mapGrammarCategoryToTranslation($grammarCategory);
        $wikiText = "=== {{S|$categoryCode|$langCode}} ===" . "\r\n";
        $wikiText .= "'''$label''' {{pron||$langCode}}" . "\r\n";
        $wikiText .= "# $translation" . "\r\n";

        for ($i = 0; $i < count($exampleLabels); $i++) {
            $examplelabel = $exampleLabels[$i];
            $exampleTranslation = $exampleTranslations[$i];
            $wikiText .= "#* $examplelabel" . "\r\n";
            $wikiText .= "#*: $exampleTranslation" . "\r\n";
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

    private function mapGrammarCategoryToTranslation(string $grammarCategory): string {
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
}
