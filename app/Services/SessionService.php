<?php

namespace App\Services;

use Illuminate\Http\Request;

class SessionService {
	public static function set(array $keys, Request $request): void {
		$sessionKeys = [];
		foreach ($keys as $key){
			if($request->get($key) !== null){
				$sessionKeys[$key] = $request->input($key);
			}
		}

		// Persit to session
		session($sessionKeys);
	}

	public static function remove(array $keys): void {

		// Flush session keys
		session()->forget($keys);
		session()->flush();
	}
}
