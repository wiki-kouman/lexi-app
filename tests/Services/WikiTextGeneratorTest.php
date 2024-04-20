<?php

namespace Tests\Services;

use App\Services\WikiTextGenerator;
use App\Services\WikiTextParser;
use PHPUnit\Framework\TestCase;

class WikiTextGeneratorTest extends TestCase
{
    private WikiTextGenerator $generator;
    private WikiTextParser $parser;

    /**
     */
    protected function setUp(): void{
        $wikiText = file_get_contents('./sample/sampleWikiTextUpdate.txt');
        $this->generator = new WikiTextGenerator;
        $this->parser = new WikiTextParser('barra', $wikiText);
        $this->parser->parse();
    }

    public function test_sentence_format_should_capitalize_and_add_dots_when_missing(): void
    {
        $text = "lorem ipsum dolor";
        $formattedText = $this->generator->sentenceFormat($text);
        $this->assertTrue(str_ends_with($formattedText, '.'));
        $this->assertTrue(str_starts_with($formattedText, 'L'));
    }


    public function test_sentence_format_should_detect_existing_punctuations(): void
    {
        $text = "lorem ipsum dolor ? ";
        $formattedText = $this->generator->sentenceFormat($text);
        $this->assertTrue(str_ends_with($formattedText, '?'));
    }

    public function test_get_closest_language_code_keeps_french_at_the_top(): void
    {
        $closestLanguageCode = $this->generator->getClosestLanguageCode($this->parser, 'adj');
        $this->assertSame('fr', $closestLanguageCode);
    }

    public function test_get_closest_language_code_keeps_alphabetical_order(): void
    {
        $closestLanguageCode = $this->generator->getClosestLanguageCode($this->parser, 'da');
        $this->assertSame('af', $closestLanguageCode);
    }

    public function test_get_add_language_section_appends_new_text(): void {
        $langWikitext = <<<EOT
        == {{langue|adj}} ==
        === {{S|verbe|adj|flexion}} ===
        '''bara''' {{pron|ba.ʁa|fr}}
        # ''Troisième personne du singulier du passé simple de'' [[barer]].
        EOT;

        $updatedPageWikitext = $this->generator
            ->appendSection(
                $this->parser,
                'adj',
                $langWikitext
            );

        $this->assertNotSame($this->parser->wikitext, $updatedPageWikitext);
    }

    public function test_get_add_language_section_works_without_default_languages(): void {
        $langWikitext = <<<EOT
        == {{langue|adj}} ==
        === {{S|verbe|adj|flexion}} ===
        '''bara''' {{pron|ba.ʁa|fr}}
        # ''Troisième personne du singulier du passé simple de'' [[barer]].
        EOT;

        $this->parser->wikitext = <<<EOT
        == {{langue|any}} ==
        === {{S|nom|any}} ===
        '''nzue''' {{pron||any}}
        # [[eau|Eau]].
        #*''kaku a nun '''nzue'''.''
        #*: Kakou a bu de l’eau.
        [[Catégorie:agni de Côte d’Ivoire]]

        == {{langue|bci}} ==
        === {{S|nom|bci}} ===
        '''nzue''' {{pron||bci}}
        # [[eau]]
        # [[pluie]]

        == {{langue|sfw}} ==
        === {{S|nom|sfw}} ===
        '''nzue''' {{pron||sfw}}
        # [[eau|Eau]].

        EOT;

        $updatedPageWikitext = $this->generator
            ->appendSection(
                $this->parser,
                'adj',
                $langWikitext
            );

        $this->assertMatchesRegularExpression("{{langue\|adj}}", $updatedPageWikitext);
        $this->assertMatchesRegularExpression(
            "{{langue\|adj}}",
            explode("\n", $updatedPageWikitext)[0]
        );

    }
}
