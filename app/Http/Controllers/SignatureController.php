<?php

namespace App\Http\Controllers;

use App\Services\MediawikiAPIService;
use App\Services\OAuthService;
use App\Services\SignatureService;
use Illuminate\View\View;

class SignatureController extends Controller {
    private string $MESSAGE_SUCCESS = 'Your signature was added successfully to Wikitonary.';
    private string $MESSAGE_ERROR = 'The change you requested has failed. Please try again.';
    private string $MESSAGE_DUPLICATE_SIGNATURE = 'Sorry, It seems you have already signed recently.';
    private string $MESSAGE_CONFIRM_ACTION = 'Do confirm that you want to sign on Wikitionary?';
	private string $MESSAGE_HEADING = 'On-wiki signature';
	private string $SIGNATURE_CODE = '#~~~~';

	public function preSign(): View {
		$message = $this->MESSAGE_CONFIRM_ACTION;
		$heading = $this->MESSAGE_HEADING;
		$operation = '/wiki/sign/confirm';
		return view('messages/confirm', compact('message', 'operation', 'heading'));
    }

	public function sign(): View {
		$message = $this->MESSAGE_SUCCESS;
		$status = false;
		$newURL = config('app.MW_ROOT_URL') . '/' . config('app.MW_SIGNATURE_PAGE');

		// Check whether signature has already happened
		$mediawikiAPIService = MediawikiAPIService::getInstance();
		$signaturePageWikitext = MediawikiAPIService::getPageLastSection(config('app.MW_SIGNATURE_PAGE'));
		$hasAlreadySigned = SignatureService::isDuplicate(OAuthService::getCachedUserInfo(), $signaturePageWikitext);

		if(!$hasAlreadySigned){
			$status = $mediawikiAPIService->addSignature(
				config('app.MW_SIGNATURE_PAGE'),
				OAuthService::getCachedUserInfo(),
				$this->SIGNATURE_CODE
			);
		}

		if(!$status || $hasAlreadySigned){
			$message = $hasAlreadySigned ? $this->MESSAGE_DUPLICATE_SIGNATURE : $this->MESSAGE_ERROR;
			return view('messages/error', compact('message'));
		}

		return view('messages/success', compact('message', 'newURL'));
	}
}
