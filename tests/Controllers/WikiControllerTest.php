<?php

namespace Tests\Controllers;

use App\Http\Controllers\WikiController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class WikiControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([
            Authenticate::class,
            VerifyCsrfToken::class
        ]);
    }

    public function testPreviewShouldReturnProperViewWhenAllFieldsProvided(): void
    {
        $this->postJson(
            uri: '/wiki/preview',
            data: $this->getMockPayload()
        )->assertViewIs('term.preview');
    }

    public function testPreviewShouldReturnErrorViewWhenMissingFields(): void
    {
        $payload = $this->getMockPayload();
		$payload['operation'] = 'add';
		unset($payload['category']);

        $this->postJson(
            uri: '/wiki/preview',
            data: $payload
        )->assertViewIs('messages.error');
    }

    public function testPreviewShouldReturnErrorViewWhenBoldTextMissing(): void
    {
        $payload = $this->getMockPayload();
		$payload['exampleLabel'] = ["lorem ipsum dolor"];

        $this->postJson(
            uri: '/wiki/preview',
            data: $payload
        )->assertViewIs('messages.error');
    }

    public function testPreviewShouldReturnErrorViewWhenArrayNotProvidedForExamples(): void
    {
        $payload = $this->getMockPayload();
        $payload['exampleLabel'] = 'string';
        $payload['operation'] = 'update';

        $this->postJson(
            uri: '/wiki/preview',
            data: $payload
        )->assertViewIs('messages.error');
    }

	public function testGetTitleAndNewURLShouldReturnSandboxedURLWhenEnvIsLocal(): void{
		$controller = new WikiController;

		Config::set('env', $controller->ENV_TEST);
		list($pageTitle) = $controller->getTitleAndNewURL('Test');
		$this->assertSame( config('app.MW_SANDBOX_PAGE') . '/Test', $pageTitle);

		Config::set('env', $controller->ENV_PROD);
		list($pageTitle) = $controller->getTitleAndNewURL('Test');
		$this->assertSame( 'Test', $pageTitle);

	}
    private function getMockPayload() : array {
        return [
            'category'                  => 'adv',
            'language'                  => 'adj',
            'definitionLabel'           => 'deli',
            'operation'           		=> 'add',
            'definitionTranslation'     => 'child',
            'exampleLabel'              => ["lorem ipsum '''dolor'''"],
            'exampleTranslation'        => ['set amet clara']
        ];
    }
}
