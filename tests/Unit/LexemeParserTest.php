<?php

namespace Tests\Unit;

use App\Services\LexemeParser;
use PHPUnit\Framework\TestCase;

class LexemeParserTest extends TestCase
{
    private LexemeParser $parser;
    protected function setUp(): void{
        $wikiText = file_get_contents('./sample/sampleWikiText.txt');
        $this->parser = new LexemeParser('barra', $wikiText);
    }
    public function test_extract_lexeme_should_contain_categories(): void
    {
        $lexeme = $this->parser->parse();
        echo(json_encode($lexeme));
        $this->assertTrue(count($lexeme->getCategories()) > 1);
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

        $types = $this->parser->extractCategories($wikitext, 'fr');
        $this->assertNotEmpty($types);
    }


    public function test_extract_definitions_should_return_array(): void
    {
        $wikitext = <<<EOT
        === {{S|nom|dyu}} ===
        '''bara''' {{pron||dyu}}
        # Travail.
        #*'''''Bara''' be thiama''
        #:Il y a beaucoup de travail
        EOT;

        $definitions = $this->parser->extractDefinitions($wikitext, );
        $this->assertNotEmpty($definitions);
    }

    public function test_extract_definitions_should_return_array(): void
    {
        $wikitext = <<<EOT
        === {{S|nom|any}} ===
        '''nzue''' {{pron||any}}
        # [[eau|Eau]].
        #*''kaku a nun '''nzue'''.''
        #*: Kakou a bu de l’eau.
        [[Catégorie:agni de Côte d’Ivoire]]

        == {{langue|bci}} ==
        === {{S|étymologie}} ===
        : {{ébauche-étym|bci}}

        === {{S|nom|bci}} ===
        '''nzue''' {{pron||bci}}
        # [[eau]]
        # [[pluie]]
        EOT;

        $definitions = $this->parser->extractDefinitions($wikitext, );
        $this->assertNotEmpty($definitions);
    }
}
