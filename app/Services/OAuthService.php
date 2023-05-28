<?php

namespace App\Services;

use App\OAuthClient\Client;
use App\OAuthClient\ClientConfig;
use App\OAuthClient\Consumer;
use App\OAuthClient\Exception;
use App\OAuthClient\Token;
use Throwable;

class OAuthService
{
    public static function getClient (): Client {
        $conf = new ClientConfig( env('MW_OAUTH_URL') );
        $conf->setConsumer( new Consumer(env('MW_OAUTH_KEY'), env('MW_OAUTH_SECRET') ) );
        $conf->setUserAgent( 'KoumanApp MediaWikiOAuthClient/1.0' );

        return new Client( $conf );
    }

    public static function getRequestToken(): Token
    {

        $token = new Token(null, null);
        try {
            // Load the Request Token from the session.
            session_start();
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
            session_start();
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
        // Store the Request Token in the session. We will retrieve it from there when the user is sent back
        // from the wiki (see demo/callback.php).
        session_start();
        $_SESSION['request_key'] = $token->key;
        $_SESSION['request_secret'] = $token->secret;
    }

    public static function clearSession(): void
    {
        session_start();
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        return self::getAccessToken()->key != null;
    }
}
