<?php

namespace App\Services;

use App\OAuthClient\Client;
use App\OAuthClient\Exception;
use App\OAuthClient\Token;
use Illuminate\Support\Facades\Log;

class MediawikiAPIService
{
    private string $API_URL;
    public function __construct(private Client $client, private Token $accessToken )
    {
        $this->API_URL = env('MW_API_URL');
    }

    /**
     */
    public static function findByTerm(string $term) {
        $apiParams = [
            'action' => 'query',
            'list' => 'search',
            'srsearch' => $term,
            'srlimit' => 5,
            'format' => 'json',
        ];
        return json_decode(self::makeGetRequest($apiParams))->query->search;
    }


    /**
     */
    public static function getTermById(int $id): array {
        $apiParams = [
            'action' => 'parse',
            'prop' => 'wikitext',
            'pageid' => $id,
            'format' => 'json',
        ];
        return json_decode( self::makeGetRequest($apiParams), true)['parse'];
    }

    /**
     * @throws Exception
     */
    public function editPage(string $term): array {
        $this->API_URL = env('MW_API_URL');
        $editToken = $this->getEditToken();

        $apiParams = [
            'action' => 'edit',
            'title' => 'Utilisateur:African Hope',
            'section' => 'Test',
            'summary' => 'OAuth API test on Wikitonary',
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

    /**
     * @throws Exception
     */
    private function getEditToken() {
        return json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            "$this->API_URL?action=query&meta=tokens&format=json"
        ) )->query->tokens->csrftoken;
    }

    private static function makeGetRequest(array $params): bool|string
    {
        $urlRequest = env('MW_API_URL') . '?';
        $urlRequest .= http_build_query($params);

        return file_get_contents($urlRequest);
    }

    public function getUserInfo()
    {
        $apiURL = env('MW_API_URL');
        return json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            "$apiURL?action=query&meta=userinfo&uiprop=rights&format=json"
        ) );
    }
}
