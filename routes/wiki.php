<?php

use App\Services\LexemeParser;
use App\Services\MediawikiAPIService;
use Illuminate\Support\Facades\Route;


Route::get('/wiki/add', function () {
    if ( !isset( $_GET['term'] ) ) {
        echo "A parameter is missing";
        exit( 1 );
    }

    $term = $_GET['term'];
    $results = MediawikiAPIService::findByTerm($term);
    return view('results', compact('results'));
});

Route::get('/wiki/view/{termId}', function (string $termId) {
    $term = MediawikiAPIService::getTermById($termId);
    $parser = new LexemeParser($term['title'], $term['wikitext']['*'], $term['pageid']);
    $lexeme = $parser->parse();
    $groups = $lexeme->getCategoriesGroupedByLanguages();
    return view('view', compact('term', 'groups'));
});
