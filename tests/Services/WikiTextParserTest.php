<?php

namespace Tests\Services;

use App\Services\WikiTextParser;
use PHPUnit\Framework\TestCase;

class WikiTextParserTest extends TestCase
{
    private WikiTextParser $parser;
    protected function setUp(): void{
        $wikiText = file_get_contents('./sample/sampleWikiTextRead.txt');
        $this->parser = new WikiTextParser('barra', $wikiText);
    }
    public function test_extract_term_should_contain_categories(): void
    {
        $term = $this->parser->parse();
        $this->assertTrue(count($term->categories) > 1);
    }

    public function test_extract_types_should_return_array(): void
    {
        $wikitext = <<<EOT
        == {{langue|fr}} ==
        === {{S|verbe|fr|flexion}} ===
        {{fr-verbe-flexion|barer|ind.ps.3s=oui}}
        '''bara''' {{pron|ba.ʁa|fr}}
        # ''Troisième personne du singulier du passé simple de'' [[barer]].

        === {{S|prononciation}} ===
        * {{pron-rimes|ba.ʁa|fr}}
        * {{écouter|lang=fr|Côte d'Ivoire (Abidjan)||audio=LL-Q32706 (dyu)-Camara aminata-bara.wav}}
        * {{écouter|Lyon (France)||lang=fr|audio=LL-Q150 (fra)-Lyokoï-bara.wav}}
        EOT;

        $types = $this->parser->extractEntities($wikitext);
        $this->assertNotEmpty($types);
    }


    public function test_extract_definitions_should_return_array(): void
    {
        $languageCode = 'dyu';
        $categoryCode = 'nom';
        $wikitext = <<<EOT
        === {{S|$languageCode|$categoryCode}} ===
        '''bara''' {{pron||dyu}}
        # Travail.
        #*'''''Bara''' be thiama''
        #:Il y a beaucoup de travail
        EOT;

        $definitions = $this->parser->extractDefinitions(
            $wikitext,
            $languageCode,
            $categoryCode
        );
        $this->assertNotEmpty($definitions);
    }
}
