<?php

namespace Tests\Services;

use App\Services\MediawikiAPIService;
use PHPUnit\Framework\TestCase;

class MediawikiAPIServiceTest extends TestCase
{

	public function testGetPageLastSectionShouldReturnWikitext(): void
	{
		$result = MediawikiAPIService::getPageLastSection('Discussion utilisateur:African Hope');
		$this->assertNotEmpty($result);
	}
}
