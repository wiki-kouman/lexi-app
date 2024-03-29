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
    public function createPage(string $term, string $pageContent): array {
        $this->API_URL = env('MW_API_URL');
        $editToken = $this->getEditToken();
        $apiParams = [
            'action' => 'edit',
            'title' => '[Test] Creating [[' . $term . ']] / ' . env('MW_SANDBOX_PAGE'),
            'section' => 'Test',
            'summary' => env('MW_SANDBOX_COMMENT'),
            'text' => $pageContent,
            'token' => $editToken,
            'format' => 'json',
        ];

        return json_decode( $this->commitChange($apiParams));
    }

    /**
     * @throws Exception
     */
    public function editPage(string $term, string $pageContent): array {
        $this->API_URL = env('MW_API_URL');
        $editToken = $this->getEditToken();
        $apiParams = [
            'action' => 'edit',
            'title' => '[Test] Editing [[' . $term . ']] / ' . env('MW_SANDBOX_PAGE'),
            'section' => 'Test',
            'summary' => env('MW_SANDBOX_COMMENT'),
            'text' => $pageContent,
            'token' => $editToken,
            'format' => 'json',
        ];

        return json_decode( $this->commitChange($apiParams));
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

    /**
     * @throws Exception
     */
    private function commitChange($apiParams): string
    {
        return $this->client->makeOAuthCall(
            $this->accessToken,
            $this->API_URL,
            true,
            $apiParams
        );
    }
}
