<?php

namespace Tests\Services;

use App\Services\OAuthService;
use App\Services\SignatureService;
use App\Services\WikiTextParser;
use PHPUnit\Framework\TestCase;

class SignatureServiceTest extends TestCase
{
	public function testIsDuplicateShouldDetextStringMatching(): void
	{
		$user = (object)['name' => 'African Hope'];
		$wikiText = <<<EOT
		== Atelier Rukuni Kouman Isu au Lycée Tiapani Dabou ==
		#[[Utilisateur:Utilisateur1|Utilisateur1]] ([[Discussion utilisateur:Utilisateur1|discussion]]) 30 avril 2024 à 16:19 (UTC)
		#[[Utilisateur:Utilisateur2|Utilisateur2]] ([[Discussion utilisateur:Utilisateur2|discussion]]) 30 avril 2024 à 16:50 (UTC)
		#[[Utilisateur:Utilisateur3|Utilisateur3]] ([[Discussion utilisateur:Utilisateur3|discussion]]) 30 avril 2024 à 16:59 (UTC)
		#[[Utilisateur:Utilisateur4|Utilisateur4]] ([[Discussion utilisateur:Utilisateur4|discussion]]) 30 avril 2024 à 17:04 (UTC)
		#[[Utilisateur:Utilisateur5|Utilisateur5]] ([[Discussion utilisateur:Utilisateur5|discussion]]) 30 avril 2024 à 17:08 (UTC)
		#[[Utilisateur:Utilisateur6|Utilisateur6]] ([[Discussion utilisateur:Utilisateur6|discussion]]) 30 avril 2024 à 17:17 (UTC)
		#[[Utilisateur:Utilisateur7|Utilisateur7]] ([[Discussion utilisateur:Utilisateur7|discussion]]) 30 avril 2024 à 17:22 (UTC)
		EOT;

		$status = SignatureService::isDuplicate($user, $wikiText);
		$this->assertFalse($status);

		$wikiText .= '\n';
		$wikiText .= '#[[Utilisateur:African Hope|Hope]] ([[Discussion utilisateur:African Hope|Hope]]) 30 avril 2024 à 17:22 (UTC)';
		$status = SignatureService::isDuplicate($user, $wikiText);
		$this->assertTrue($status);
	}
}
