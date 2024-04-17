<?php

namespace Tests\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Providers\AuthServiceProvider;
use App\Services\OAuthService;
use Illuminate\Support\Facades\Auth;
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
            uri: '/wiki/preview?operation=add',
            data: $this->getMockPayload()
        )->assertViewIs('term.preview');
    }

    public function testPreviewShouldReturnErrorViewWhenMissingFields(): void
    {
        $payload = $this->getMockPayload();
        unset($payload['category']);

        $this->postJson(
            uri: '/wiki/preview?operation=add',
            data: $payload
        )->assertViewIs('messages.error');
    }

    public function testPreviewShouldReturnErrorViewWhenArrayNotProvidedForExamples(): void
    {
        $payload = $this->getMockPayload();
        $payload['exampleLabel'] = 'string';

        $this->postJson(
            uri: '/wiki/preview?operation=update',
            data: $payload
        )->assertViewIs('messages.error');
    }

    private function getMockPayload() : array {
        return [
            'category'                  => 'adv',
            'language'                  => 'adj',
            'definitionLabel'           => 'deli',
            'definitionTranslation'     => 'child',
            'exampleLabel'              => ['lorem ipsum dolor'],
            'exampleTranslation'        => ['set amet clara']
        ];
    }
}
