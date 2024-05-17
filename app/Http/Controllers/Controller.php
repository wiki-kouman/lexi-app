<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	protected static array $SUPPORTED_FIELDS = [
		'operation',
		'category',
		'language',
		'definitionLabel',
		'definitionTranslation',
		'exampleLabel',
		'exampleTranslation'
	];

	use AuthorizesRequests, ValidatesRequests;
	protected function clearSessionInputs(): void {
		SessionService::remove(self::$SUPPORTED_FIELDS);
	}
}
