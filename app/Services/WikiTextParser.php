<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Definition;
use App\Models\Language;
use App\Models\Term;

class WikiTextParser
{


    public Term $term;
    public function __construct(
        private readonly string $label,
        private readonly string $wikitext,
        private readonly int    $termId = 0)
    {
        $this->term= new Term($this->label, []);
    }

    public function parse(): Term {
        $pattern = "/^==?.*(langue)(?:(?!^\n?.*(langue))[\S\s])*$/m";

        // Use Regex to get a high-level list of languages as distinct wikitext blocs
        preg_match_all($pattern, $this->wikitext, $matches);

        // Extract array of languages, categories, and definitions
        foreach ($matches[0] as $wikitextBloc) {
            $this->extractEntities($wikitextBloc, $this->termId);
        }

        return $this->term;
    }

    /**
     * @param string $wikitext
     * @return array
     * @link https://fr.wiktionary.org/wiki/Aide:Types_de_mots
     */
    public function extractEntities(string $wikitext): array {

        $languageCode = $this->extractLanguageCode($wikitext);
        $categories = $this->extractCategories($wikitext);

        // Generate Category[]
        foreach ($categories as $categoryWikiText){
            $categoryCode = $this->extractCategoryCode($categoryWikiText);
            $this->term->categories[$languageCode] = new Category(
                $categoryCode,
                $languageCode,
                $categoryWikiText
            );

            // Generate Definition[]
            $this->extractDefinitions(
                $categoryWikiText,
                $categoryCode,
                $languageCode
            );

            // Generate a list of languages and categories
            $this->term->languagesAndCategories[$languageCode][] = $categoryCode;

        }

        return $this->term->categories;
    }

    /**
     * @param string $wikitext
     * @param string $categoryCode
     * @param string $languageCode
     * @return Definition[]
     */
    public function extractDefinitions(string $wikitext, string $categoryCode, string $languageCode): array
    {
        $pattern = "/^# ?.*(?:(?!^(# |\n))[\S\s])*$/m";

        // Use Regex to get a high-level list of definitions as distinct wikitext blocs
        preg_match_all($pattern, $wikitext, $matches);
        $results = $matches[0];
        $regexPattern = "/(' |'(?=\s|\b)|\"\"\"|#|\*|\:|\'\'|\[\[.*\||{{.*\}})|\]|\./";

        // Loop through each group of wikitext definitions to create a Definition[] array
        foreach($results as $result){
            $lines = array_filter(array_map(
                function ($definition) {
                    return trim($definition);
                }, explode("\n", trim($result))
            ), 'strlen');

            // Create new Definition object and populate it
            if(isset($lines[0])) {
                $groupKey = $languageCode . $categoryCode;
                $this->term->definitions[$groupKey][] = new Definition(
                    $this->term->label,
                    $lines[0],
                    $lines[1] ?? null,
                    $categoryCode,
                    $languageCode,
                    array_slice($lines, 1)
                );
            }

        }

        return $this->term->definitions;
    }

    /**
     * @param string $wikitext
     * @return string
     */
    private function extractCategoryCode(string $wikitext): string
    {
        $regexPattern = "/===?.{{.*(adverbe|pronom|nom|adjectif|verbe|interjection).*}}/m";
        preg_match_all($regexPattern, $wikitext, $matches);
        return $matches[1][0] ?? '';
    }

    /**
     * @param string $wikitext
     * @return string
     */
    private function extractLanguageCode(string $wikitext): string
    {
        $regexPattern = "/{{langue\|(\w+)}}/m";
        preg_match_all($regexPattern, $wikitext, $matches);
        return $matches[1][0] ?? '';
    }

    private function extractCategories(string $wikiText): array {
        $pattern = "/^===?.*(verbe|pronom|nom|adjectif|adj-int|adverbe|interjection)(?:(?!^\n)[\S\s])*$/m";
        // Use Regex to get a high-level list of grammar categories as distinct wikitext blocs
        preg_match_all($pattern, $wikiText, $matches);

        return $matches[0];
    }
}
