<?php

namespace App\Http\Controllers;

use App\Services\OAuthService;
use App\Services\WikiTextGenerator;
use App\Services\WikiTextParser;
use App\Services\MediawikiAPIService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikiController extends Controller {
    public function search(Request $request) {
        if ( $request->get('term') == null) {
            echo "A parameter is missing";
            exit( 1 );
        }

        $term = $_GET['term'];
        $results = MediawikiAPIService::findByTerm($term);
        $isExistent = MediawikiAPIService::isExistent($term);

        return view('term/results', compact('term', 'results', 'isExistent'));
    }

    public function add(string $term): View {
        return view('term/add', compact('term'));
    }

    public function update(int $termId): View {
        $term = MediawikiAPIService::getTermById($termId);
        return view('term/update', compact('term'));
    }

    public function view (string $termId): View {
        $term = MediawikiAPIService::getTermById($termId);
        $parser = new WikiTextParser($term['title'], $term['wikitext']['*'], $term['pageid']);
        $lexeme = $parser->parse();
        $groups = $lexeme->getCategoriesGroupedByLanguages();
        return view('term/view', compact('term', 'groups'));
    }

    public function preview(Request $request): View {
        $label = $request->get('definitionLabel');
        $translation = $request->get('definitionTranslation');
        $grammarCategory = $request->get('category');
        $langCode = $request->get('language');
        $exampleLabels = $request->get('exampleLabel');
        $exampleTranslations = $request->get('exampleTranslation');

        $wikiTextGenerator = (new WikiTextGenerator);
        $wikiText = $wikiTextGenerator->wordToWikiText(
            $label,
            $translation,
            $grammarCategory,
            $langCode,
            $exampleLabels,
            $exampleTranslations
        );

        $wikiText = $wikiTextGenerator->addNewLanguageSection($langCode) . $wikiText;
        $wikiText .= $wikiTextGenerator->addWikiCategory($langCode);
        $htmlText = MediawikiAPIService::previewWikiText($wikiText);

        return view('term/preview', compact('htmlText','wikiText', 'label'));
    }

    public function create(Request $request): View {
        $wikiText = $request->get("wikiText");
        $term = $request->get("term");
        $message = 'The change you requested has failed. Please try again.';

        // Get requestToken from session
        $client = OAuthService::getClient();
        $accessToken = OAuthService::getAccessToken();
        $mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
        $status = $mediawikiAPIService->addSection($term, $wikiText);

        // Display an error message if there's a failure
        if(!$status){
            return view('messages/error', compact('message'));
        }

        $message = 'The page was updated successfully.';
        return view('messages/success', compact('message'));
    }
}
