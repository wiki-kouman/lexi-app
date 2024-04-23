<?php

namespace App\Services;

use App\DTO\TermDTO;
use function PHPUnit\Framework\isEmpty;

class WikiTextGenerator {
	private string $LANG_CODE = 'fr';
	private string $CONV_LANGUAGE_CODE = 'conv';

	public static function generate(TermDTO $term): string
	{
		$generator = new self;
		$wikiText = $generator->wordToWikiText($term);
		return $generator->languageToWikiText($term->language) . $wikiText;
	}

	public function wordToWikiText(TermDTO $term): string {
		$categoryCode = $this->mapGrammarCategoryToTranslation($term->category);
		$wikiText = "=== {{S|$categoryCode|$term->language}} ===" . "\r\n";
		$wikiText .= "'''$term->label''' {{pron||$term->language}}" . "\r\n";
		$wikiText .= "# ". $this->sentenceFormat($term->labelTranslation) . "\r\n";

		if(count($term->exampleLabels) > 0 && $term->exampleLabels[0] != null){
			for ($i = 0; $i < count($term->exampleLabels); $i++) {
				$examplelabel = $this->sentenceFormat($term->exampleLabels[$i]);
				$exampleTranslation = $this->sentenceFormat($term->exampleTranslations[$i]);
				$wikiText .= "#* {{exemple |$examplelabel |sens=$exampleTranslation |lang=$term->language}}" . "\r\n";
			}
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
	 * @param string $addedWikitext
	 * @return string
	 */
	public function appendSection(WikiTextParser $parser, string $langCode, string $addedWikitext): string
	{
		$closestLangCode = $this->getClosestLanguageCode($parser, $langCode);
		$closestLangWikitext = $this->getClosestLanguageWikitext($closestLangCode, $parser->wikitext);
		$newWikiText = $parser->wikitext;

		if( !empty($closestLangWikitext)) {
			$regexPattern = "/(^==?.*(langue\|$closestLangCode)(?:(?!^==?.*(langue))[\S\s])*)/m";

			// Define the replacement string with the new language section
			$replacement = "$1\n\n$addedWikitext";
			$newWikiText = preg_replace($regexPattern, $replacement, $newWikiText, 1);

		} else if(preg_match("{{langue\|$this->LANG_CODE}}", $parser->wikitext)) {
			$newWikiText = $parser->wikitext . "\r\n\r\n" . $addedWikitext;
		} else {
			// By default, append it to the top of the text
			$newWikiText = $addedWikitext . "\r\n\r\n". $parser->wikitext;
		}

		return $newWikiText;
	}

	public function getClosestLanguageCode(WikiTextParser $parser, string $newlangCode): string {

		$sections = $parser->term->languagesAndCategories;
		// Discard default language codes as they must remain at the top
		unset($sections[$this->LANG_CODE]);
		unset($sections[$this->CONV_LANGUAGE_CODE]);
		$sections = array_keys($sections);

		// Add langCode to an array and sort it to find out where to append the wikitext
		$closestLangCode = $this->LANG_CODE;
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
