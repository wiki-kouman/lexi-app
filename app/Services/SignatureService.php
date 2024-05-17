<?php

namespace App\Services;

class SignatureService {

	public static function isDuplicate(object $user, string $wikiText): bool {
		return preg_match("/$user->name/", $wikiText) == 1;
	}
}
