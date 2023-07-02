<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Definition;
use App\Models\Language;
use App\Models\Lexeme;

class LexemeParser
{

    public function __construct(
        private readonly string $label,
        private readonly string $wikitext,
        private readonly int $lexemeId = 0){
    }

    public function parse(): Lexeme {
        $categories = [];
        $pattern = "/^==?.*(langue)(?:(?!^\n?.*(langue))[\S\s])*$/m";

        // Use Regex to get a high-level list of languages as distinct wikitext blocs
        preg_match_all($pattern, $this->wikitext, $matches);

        foreach ($matches[0] as $wikitextBloc) {
            $langCode = $this->extractLanguageCode($wikitextBloc);
            $categories = array_merge(
                $categories, $this->extractCategories($wikitextBloc, $langCode, $this->lexemeId)
            );
        }

        return new Lexeme($this->label, $categories);
    }

    /**
     * @param string $wikitext
     * @param string $languageCode
     * @param int $lexemeId
     * @return array
     * @link https://fr.wiktionary.org/wiki/Aide:Types_de_mots
     */
    public function extractCategories(string $wikitext, string $languageCode, int $lexemeId = 0): array {
        $pattern = "/^===?.*(verbe|pronom|nom|adjectif|adverbe|interjection)(?:(?!^\n)[\S\s])*$/m";

        // Use Regex to get a high-level list of grammar categories as distinct wikitext blocs
        preg_match_all($pattern, $wikitext, $matches);

        return array_map(function($categoryWikitext) use ($lexemeId, $languageCode)
        {
            $language = new Language($languageCode, $languageCode);
            $categoryCode = $this->extractCategoryCode($categoryWikitext);
            $definitions = $this->extractDefinitions($categoryWikitext);
            return new Category($lexemeId, $categoryCode, $categoryCode, $language, $definitions);
        }, $matches[0]);
    }

    /**
     * @param string $wikitext
     * @return Definition[]
     */
    public function extractDefinitions(string $wikitext): array
    {
        $pattern = "/^# ?.*(?:(?!^(# |\n))[\S\s])*$/m";

        // Use Regex to get a high-level list of definitions as distinct wikitext blocs
        preg_match_all($pattern, $wikitext, $matches);
        $results = $matches[0];
        $definitions = [];
        $regexPattern = "/(' |'(?=\s|\b)|\"\"\"|#|\*|\:|\'\'|\[\[.*\||{{.*\}})|\]|\./";

        // Loop through each group of wikitext definitions to create a Definition[] array
        foreach($results as $result){
            $lines = array_filter(array_map(
                function ($definition) use ($regexPattern) {
                    return trim(
                        preg_replace(
                            $regexPattern,
                            "",
                            $definition)
                    );
                }, explode("\n", trim($result))
            ), 'strlen');

            // Create new Definition object and populate it
            $definitions[] = new Definition(
                $lines[0] ?? null,
                $this->lexemeId,
                array_slice($lines, 1)
            );
        }

        return $definitions;
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
}
