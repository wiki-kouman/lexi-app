<?php

namespace App\Services;

use App\OAuthClient\Client;
use App\OAuthClient\Exception;
use App\OAuthClient\Token;

class MediawikiAPIService
{
    private string $API_URL;
    public function __construct(private readonly Client $client, private readonly Token $accessToken )
    {
        $this->API_URL = config('app.MW_API_URL');
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

    public function createPage(string $term, string $pageTitle, string $wikiText): bool {
        try {
            $editToken = $this->getEditToken();
            $apiParams = [
                'action' => 'edit',
                'title' => $pageTitle,
                'createonly' => true,
                'bot' => true,
                'summary' => '+' . $term  . ' | ' . config('app.MW_SANDBOX_COMMENT'),
                'text' => $wikiText,
                'token' => $editToken,
                'format' => 'json',
            ];

            $result = json_decode($this->commitChange($apiParams));
            if(!property_exists($result , "error")){
                return true;
            }
        } catch (Exception $e){
            // TODO: Do something with the error, log it etc.
        }

        return false;
    }


    public function addSection(string $pageTitle, string $term, string $wikiText): bool {
        try {
            $editToken = $this->getEditToken();
            $apiParams = [
                'action' => 'edit',
                'title' => $pageTitle,
                'summary' => '+' . $term  . ' | ' . config('app.MW_SANDBOX_COMMENT'),
                'appendtext' => "\r\n". "\r\n" . $wikiText,
                'token' => $editToken,
                'bot' => true,
                'format' => 'json',
            ];

            $result = json_decode($this->commitChange($apiParams));

            if(!property_exists($result , "error")){
                return true;
            }
        } catch (Exception $e){
            // TODO: Do something with the error, log it etc.
        }

        return false;
    }

    public function editPage(string $pageTitle, string $term, string $wikiText): bool {
        try {
            $editToken = $this->getEditToken();
            $apiParams = [
                'action' => 'edit',
                'title' => $pageTitle,
                'text' => $wikiText,
                'token' => $editToken,
                'summary' => '+' . $term  . ' | ' . config('app.MW_SANDBOX_COMMENT'),
				'nocreate' => str(config('app.env')) === 'production',
                'format' => 'json',
            ];

            $result = json_decode($this->commitChange($apiParams));

            if(!property_exists($result , "error")){
                return true;
            }
        } catch (Exception $e){
            // TODO: Do something with the error, log it etc.
        }
        return false;
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
        $urlRequest = config('app.MW_API_URL') . '?';
        $urlRequest .= http_build_query($params);

        return file_get_contents($urlRequest);
    }

    /**
     * @throws Exception
     */
    public function getUserInfo()
    {
        $apiURL = config('app.MW_API_URL');
        return json_decode( $this->client->makeOAuthCall(
            $this->accessToken,
            "$apiURL?action=query&meta=userinfo&uiprop=rights&format=json"
        ) );
    }

    /**
     * @throws Exception
     */
    private function commitChange($apiParams): string {
        return $this->client->makeOAuthCall(
            $this->accessToken,
            $this->API_URL,
            true,
            $apiParams
        );
    }

    public static function isExistent(string $term): bool {
        $apiParams = [
            'action' => 'query',
            'titles' => $term,
            'format' => 'json',
        ];

        $results = json_decode(self::makeGetRequest($apiParams))->query->pages;

        if(property_exists($results, "-1")){
            return false;
        }

        return true;
    }

    public static function previewWikiText(string $wikiText): string {
        $apiParams = [
            'action' => 'parse',
            'title' => 'Test',
            'text' => $wikiText,
            'format' => 'json',
        ];

        return json_decode(self::makeGetRequest($apiParams))->parse->text->{"*"};
    }}
