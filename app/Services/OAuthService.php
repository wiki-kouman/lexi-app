<?php

namespace App\Services;

use App\OAuthClient\Client;
use App\OAuthClient\ClientConfig;
use App\OAuthClient\Consumer;
use App\OAuthClient\Token;
use Throwable;

class OAuthService
{
    public static function getClient (): Client {
        $conf = new ClientConfig( env('MW_OAUTH_URL') );
        $conf->setConsumer( new Consumer(env('MW_OAUTH_KEY'), env('MW_OAUTH_SECRET') ) );
        $conf->setUserAgent( env('MW_USER_AGENT') );

        return new Client( $conf );
    }

    public static function getRequestToken(): Token
    {

        $token = new Token(null, null);
        try {
            // Load the Request Token from the session.
            if(!isset($_SESSION)) {
                session_start();
            }
            return new Token( $_SESSION['request_key'], $_SESSION['request_secret'] );
        } catch (Throwable $e){
            return $token;
        }
    }

    public static function getAccessToken(): Token
    {
        $token = new Token(null, null);
        try {
            // Load the Access Token from the session.
            if(!isset($_SESSION)) {
                session_start();
            }
            return new Token( $_SESSION['access_key'], $_SESSION['access_secret'] );
        } catch (Throwable $e){
            return $token;
        }
    }

    public static function addAccessTokenToSession(Token $accessToken): void
    {
        $_SESSION['access_key'] = $accessToken->key;
        $_SESSION['access_secret'] = $accessToken->secret;

        // You also no longer need the Request Token.
        unset( $_SESSION['request_key'], $_SESSION['request_secret'] );
    }

    public static function addRequestTokenToSession(Token $token): void
    {
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['request_key'] = $token->key;
        $_SESSION['request_secret'] = $token->secret;
    }

    public static function clearSession(): void
    {
        if(!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return isset(self::getAccessToken()->key);
    }
}
