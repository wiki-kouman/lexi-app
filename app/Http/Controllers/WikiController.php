<?php

namespace App\Http\Controllers;

use App\Services\LexemeParser;
use App\Services\MediawikiAPIService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikiController extends Controller
{
    public function add() {
        if ( !isset( $_GET['term'] ) ) {
            echo "A parameter is missing";
            exit( 1 );
        }

        $term = $_GET['term'];
        $results = MediawikiAPIService::findByTerm($term);
        return view('results', compact('results'));
    }

    public function view (string $termId): View {
        $term = MediawikiAPIService::getTermById($termId);
        $parser = new LexemeParser($term['title'], $term['wikitext']['*'], $term['pageid']);
        $lexeme = $parser->parse();
        $groups = $lexeme->getCategoriesGroupedByLanguages();
        return view('view', compact('term', 'groups'));
    }
}
