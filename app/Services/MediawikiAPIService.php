<?php

namespace App\Services;

use App\OAuthClient\Client;
use App\OAuthClient\Exception;
use App\OAuthClient\Token;

class MediawikiAPIService
{
    private string $API_URL;
    public function __construct(private Client $client, private Token $accessToken )
    {
        $this->API_URL = env('MW_API_URL');
    }

    /**
     * @throws Exception
     */
    public function findByTerm(string $term): array {
        $this->API_URL = env('MW_API_URL');
        $editToken = json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            "$this->API_URL?action=query&meta=tokens&format=json"
        ) )->query->tokens->csrftoken;
        $apiParams = [
            'action' => 'edit',
            'title' => 'User:African Hope',
            'section' => 'new',
            'summary' => 'Hello World',
            'text' => 'This is a preliminary test using OAuth API.',
            'token' => $editToken,
            'format' => 'json',
        ];

        return json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            $this->API_URL,
            true,
            $apiParams)
        );
    }

    public function getUserInfo()
    {
        $this->API_URL = env('MW_API_URL');
        return json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            "$this->API_URL?action=query&meta=userinfo&uiprop=rights&format=json"
        ) );
    }
}
