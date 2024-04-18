<?php

namespace Tests\Services;

use App\Services\WikiTextGenerator;
use PHPUnit\Framework\TestCase;

class WikiTextGeneratorTest extends TestCase
{
    private WikiTextGenerator $generator;

    /**
     */
    protected function setUp(): void{
        $this->generator = new WikiTextGenerator;
    }

    public function test_sentence_format_should_capitalize_and_add_dots_when_missing(): void
    {
        $text = "lorem ipsum dolor";
        $formattedText = $this->generator->sentenceFormat($text);
        $this->assertTrue(str_ends_with($formattedText, '.'));
        $this->assertTrue(str_starts_with($formattedText, 'L'));
    }
}
