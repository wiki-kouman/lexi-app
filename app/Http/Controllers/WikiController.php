<?php

namespace App\Http\Controllers;

use App\Services\OAuthService;
use App\Services\SessionService;
use App\Services\WikiTextGenerator;
use App\Services\WikiTextParser;
use App\Services\MediawikiAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class WikiController extends Controller {
    private string $MESSAGE_SUCCESS = 'The page was updated successfully.';
    private string $MESSAGE_ERROR = 'The change you requested has failed. Please try again.';
    private string $MESSAGE_EMPTY_FIELDS = 'Sorry, it seems some information was not provided. Please make sure you provided details such as category, language and examples.';
    private string $MESSAGE_DUPLICATE_SECTION = 'Sorry, it seems that the section you are trying to add already exists on the Wikitionary page.';

    public function search(Request $request): View {
		$validator = Validator::make(
            $request->all(), [ 'term' => 'required|alpha' ]
        );

		// Store user input in cache
		SessionService::set(['term'], $request);

		if($validator->fails()){
            $message = $this->MESSAGE_ERROR;
            return view('messages/error', compact('message'));
        }


        $term = $request->get('term');
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
        return view('term/update', compact('term', 'termId', 'pageURL'));
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

    public function preview (Request $request): View {
        $validationRules = [
            'operation'                 => 'required',
            'definitionLabel'           => 'required|alpha',
            'definitionTranslation'     => 'required|min:3',
            'category'                  => 'required|alpha',
            'language'                  => 'required|alpha',
			'exampleTranslation'        => 'nullable|array',
			'exampleLabel'              => ["nullable","array"],
			'exampleLabel.*'            => "regex:/'''.*'''/"
        ];

		$validator = Validator::make($request->all(), $validationRules);
        if($validator->fails()){
            $message = $this->MESSAGE_EMPTY_FIELDS;
            return view('messages/error', compact('message'));
        }

        $operation = $request->get('operation');
        $label = $request->get('definitionLabel');
        $translation = $request->get('definitionTranslation');
        $grammarCategory = $request->get('category');
        $langCode = $request->get('language');
        $exampleLabels = $request->get('exampleLabel');
        $exampleTranslations = $request->get('exampleTranslation');

		// Store user input in cache
		SessionService::set(self::$SUPPORTED_FIELDS, $request);

        $wikiTextGenerator = (new WikiTextGenerator);
        $wikiText = $wikiTextGenerator->wordToWikiText(
            $label,
            $translation,
            $grammarCategory,
            $langCode,
            $exampleLabels,
            $exampleTranslations
        );

        $wikiText = $wikiTextGenerator->languageToWikiText($langCode) . $wikiText;
        $htmlText = MediawikiAPIService::previewWikiText($wikiText);

        return view('term/preview',
            compact(
                'htmlText',
                'wikiText',
                'label',
                'operation'
            )
        );
    }

    public function add(Request $request): View {
        $validationRules = [
            'term'               => 'required|alpha',
            'wikiText'           => 'required'
        ];

        $request->validate($validationRules);

        $wikiText = $request->get("wikiText");
        $term = $request->get("term");
        $message = $this->MESSAGE_ERROR;

        // Get requestToken from session
        $mediawikiAPIService = new MediawikiAPIService(
            OAuthService::getClient(),
            OAuthService::getAccessToken()
        );
        $pageTitle = config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $newURL = config('app.MW_ROOT_URL') . '/' . config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $status = $mediawikiAPIService->createPage($term, $pageTitle, $wikiText);

        // Display an error message if there's a failure
        if(!$status){
            return view('messages/error', compact('message'));
        }

        // Clear cached user input
		$this->clearSessionInputs();
		$message = $this->MESSAGE_SUCCESS;
		return view('messages/success', compact('message', 'newURL'));
	}

    public function update(Request $request, int $termId): View {
        $message = $this->MESSAGE_ERROR;

        $validationRules = [
            'term'               => 'required|alpha',
            'wikiText'           => 'required'
        ];

        $validator = Validator::make($request->all(), $validationRules);
        if($validator->fails()){
            return view('messages/error', compact('message'));
        }

        $newWikiText = $request->get("wikiText");
        $term = $request->get("term");

        // TODO: Optimize and move business logic to services
        // Get requestToken from session
        $mediawikiAPIService = new MediawikiAPIService(
            OAuthService::getClient(),
            OAuthService::getAccessToken()
        );

        // Fetch on-wiki version of the page to edit
        $result = MediawikiAPIService::getTermById($termId);
        $generator = new WikiTextGenerator;
        $parser = new WikiTextParser($result['title'], $result['wikitext']['*'], $result['pageid']);
        $parser->parse();

        // Fail if section already exists on-wiki
        $newLangCode = $parser->extractLanguageCode($newWikiText);

        // Prepare newer version of the page
        $newWikiText = $generator->appendSection($parser, $newLangCode, $newWikiText);
        $pageTitle = config('app.MW_SANDBOX_PAGE') . '/' . $term;
        $newURL = config('app.MW_ROOT_URL') . '/' . config('app.MW_SANDBOX_PAGE') . '/' . $term;


        if( preg_match("{{langue\|$newLangCode}}", $parser->wikitext)) {
            $message = $this->MESSAGE_DUPLICATE_SECTION;
            return view('messages/error', compact('message'));
        }

        $status = $mediawikiAPIService->editPage($pageTitle, $term, $newWikiText);
        // Display an error message if there's a failure
        if(!$status){
            return view('messages/error', compact('message'));
        }

		$this->clearSessionInputs();
		$message = $this->MESSAGE_SUCCESS;
        return view('messages/success', compact('message', 'newURL'));
    }
}
