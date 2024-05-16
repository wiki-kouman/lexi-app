<?php

namespace Tests\Services;

use App\Services\OAuthService;
use App\Services\WikiTextParser;
use PHPUnit\Framework\TestCase;

class OAuthServiceTest extends TestCase
{
    public function testWhetherUserInformationIsCachedAndReturned(): void
    {
        OAuthService::addUserInfoToCache((object)['name' => 'Doe']);
        $user = OAuthService::getCachedUserInfo();
		OAuthService::clearSession();
		$this->assertSame('Doe', $user->name);
    }

	public function testWhetherUserInformationCacheIsEmptyByDefault(): void
	{
		$user = OAuthService::getCachedUserInfo();
		$this->assertSame(null, $user );
	}
}
