<?php

namespace Tests\Unit;

use App\Services\LexemeParserService;
use PHPUnit\Framework\TestCase;

class LexemeParserServiceTest extends TestCase
{
    private LexemeParserService $parser;
    protected function setUp(): void{
        $wikiText = file_get_contents('./sample/sampleWikiText.txt');
        $this->parser = new LexemeParserService($wikiText);

    }
    public function test_extract_languages_into_array(): void
    {
        $languages = $this->parser->extractLanguages();
        $this->assertTrue(count($languages) > 1);
    }

    public function test_extract_types_into_array(): void
    {
        $languages = $this->parser->extractLanguages();
        $types = $this->parser->extractTypes($languages[0]['wikitext']);
        $this->assertNotEmpty($types);
    }


    public function test_extract_definitions_into_array(): void
    {
        $languages = $this->parser->extractLanguages();
        $types = $this->parser->extractTypes($languages[6]['wikitext']);
        $definitions = $this->parser->extractDefinitions($types[0]['wikitext']);
        $this->assertNotEmpty($definitions);
    }
}
