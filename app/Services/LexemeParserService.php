<?php

namespace App\Services;

class LexemeParserService
{

    public function __construct(private readonly string $wikitext){}

    public function extractLanguages(): array {
        $pattern = "/^==?.*(langue)(?:(?!^\n?.*(langue))[\S\s])*$/m";
        preg_match_all($pattern, $this->wikitext, $matches);
        return array_map(function($language){
            $languageCode = $this->extractLanguageCode($language);
            return [
                "wikitext" => $language,
                "code" => $languageCode,
                "types" => $this->extractTypes($language)
            ];
        }, $matches[0]);

    }

    /**
     * @param string $language
     * @return array
     * @link https://fr.wiktionary.org/wiki/Aide:Types_de_mots
     */
    public function extractTypes(string $language): array {
        $pattern = "/^===?.*(verbe|pronom|nom|adjectif|adverbe|interjection)(?:(?!^\n)[\S\s])*$/m";
        preg_match_all($pattern, $language, $matches);
        return array_map(function($type){
            return [
                "wikitext" => $type,
                "code" => $this->extractTypeCode($type),
                "definitions" => $this->extractDefinitions($type)
            ];
        }, $matches[0]);
    }

    /**
     * @param string $type
     * @return array
     */
    public function extractDefinitions(string $type): array
    {
        $pattern = "/^# ?.*(?:(?!^(# |\n))[\S\s])*$/m";
        preg_match_all($pattern, $type, $matches);
        $results = $matches[0];
        $definitions = [];
        $regexPattern = "/(' |'(?=\s|\b)|\"\"\"|#|\*|\:|\'\'|\[\[.*\||{{.*\}})|\]|\./";
        foreach($results as $result){
            $definitions[] = array_filter(array_map(
                function ($definition) use ($regexPattern) {
                    return trim(
                        preg_replace(
                            $regexPattern,
                            "",
                            $definition)
                    );
                }, explode("\n", trim($result))
            ), 'strlen');
        }

        return $definitions;
    }

    private function extractTypeCode(string $wikitext): string
    {
        $regexPattern = "/===?.{{.*(adverbe|pronom|nom|adjectif|verbe|interjection).*}}/m";
        preg_match_all($regexPattern, $wikitext, $matches);
        return $matches[1][0] ?? '';
    }
    private function extractLanguageCode(string $wikitext): string
    {
        $regexPattern = "/{{langue\|(\w+)}}/m";
        preg_match_all($regexPattern, $wikitext, $matches);
        return $matches[1][0] ?? '';
    }
}
