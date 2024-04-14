<?php

namespace App\Http\Controllers;

use App\Services\OAuthService;
use App\Services\WikiTextGenerator;
use App\Services\WikiTextParser;
use App\Services\MediawikiAPIService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WikiController extends Controller {
    private string $MESSAGE_SUCCESS = 'The page was updated successfully.';
    private string $MESSAGE_ERROR = 'The change you requested has failed. Please try again.';

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

    public function preAdd(string $term): View {
        return view('term/add', compact('term'));
    }

    public function preUpdate(int $termId): View {
        $result = MediawikiAPIService::getTermById($termId);
        $term = $result['title'];
        $pageURL = config('app.MW_ROOT_URL') . '/' . $term;
        return view('term/update', compact('term', 'pageURL'));
    }

    public function view (string $termId): View {
        $result = MediawikiAPIService::getTermById($termId);
        $parser = new WikiTextParser($result['title'], $result['wikitext']['*'], $result['pageid']);
        $term = $result['title'];
        $parsedTerm = $parser->parse();
        $langCategories = $parsedTerm->languagesAndCategories;
        $definitions = $parsedTerm->definitions;
        return view('term/view', compact('term', 'langCategories', 'definitions'));
    }

    public function preview(Request $request): View {
        $action = $request->get('action');
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

        return view('term/preview',
            compact(
                'htmlText',
                'wikiText',
                'label',
                'action'
            )
        );
    }

    public function add(Request $request): View {
        $wikiText = $request->get("wikiText");
        $term = $request->get("term");
        $message = $this->MESSAGE_ERROR;

        // Get requestToken from session
        $client = OAuthService::getClient();
        $accessToken = OAuthService::getAccessToken();
        $mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
        $pageTitle = config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $newURL = config('app.MW_ROOT_URL') . '/' . config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $status = $mediawikiAPIService->createPage($term, $pageTitle, $wikiText);

        // Display an error message if there's a failure
        if(!$status){
            return view('messages/error', compact('message'));
        }

        $message = $this->MESSAGE_SUCCESS;
        return view('messages/success', compact('message', 'newURL'));
    }

    public function update(Request $request): View {
        $message = $this->MESSAGE_ERROR;
        $wikiText = $request->get("wikiText");
        $term = $request->get("term");

        // Get requestToken from session
        $client = OAuthService::getClient();
        $accessToken = OAuthService::getAccessToken();
        $mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
        $pageTitle = config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $newURL = config('app.MW_ROOT_URL') . '/' . config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $status = $mediawikiAPIService->addSection($pageTitle, $term, $wikiText);

        // Display an error message if there's a failure
        if(!$status){
            return view('messages/error', compact('message'));
        }

        $message = $this->MESSAGE_SUCCESS;
        return view('messages/success', compact('message', 'newURL'));
    }
}
