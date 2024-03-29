<?php

namespace App\Http\Controllers;

use App\Services\LexemeParser;
use App\Services\MediawikiAPIService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikiController extends Controller
{
    public function search(Request $request) {
        if ( !$request->get('term') !== null) {
            echo "A parameter is missing";
            exit( 1 );
        }

        $term = $_GET['term'];
        $results = MediawikiAPIService::findByTerm($term);
        return view('term/results', compact('results'));
    }

    public function add(Request $request, int $termId): View {
        $term = MediawikiAPIService::getTermById($termId);
        return view('term/add', compact('term'));
    }

    public function view (string $termId): View {
        $term = MediawikiAPIService::getTermById($termId);
        $parser = new LexemeParser($term['title'], $term['wikitext']['*'], $term['pageid']);
        $lexeme = $parser->parse();
        $groups = $lexeme->getCategoriesGroupedByLanguages();
        return view('term/view', compact('term', 'groups'));
    }
}
