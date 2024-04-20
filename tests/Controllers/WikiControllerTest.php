<?php

namespace Tests\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;


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
