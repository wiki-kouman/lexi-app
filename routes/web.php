<?php

use App\OAuthClient\Client;
use App\OAuthClient\ClientConfig;
use App\OAuthClient\Consumer;
use App\OAuthClient\Token;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Configure the OAuth client with the URL and consumer details.
    $conf = new ClientConfig( env('MW_OAUTH_URL') );
    $conf->setConsumer( new Consumer(env('MW_OAUTH_KEY'), env('MW_OAUTH_SECRET') ) );
    $conf->setUserAgent( 'DemoApp MediaWikiOAuthClient/1.0' );
    $client = new Client( $conf );

    // Send an HTTP request to the wiki to get the authorization URL and a Request Token.
    // These are returned together as two elements in an array (with keys 0 and 1).
    list( $oauthUrl, $token ) = $client->initiate();

    // Store the Request Token in the session. We will retrieve it from there when the user is sent back
    // from the wiki (see demo/callback.php).
    session_start();
    $_SESSION['request_key'] = $token->key;
    $_SESSION['request_secret'] = $token->secret;

    // Redirect the user to the authorization URL. This is usually done with an HTTP redirect, but we're
    // making it a manual link here so you can see everything in action.
    return view('welcome', compact('oauthUrl'));
});

Route::get('/oauth-callback', function () {
    if ( !isset( $_GET['oauth_verifier'] ) ) {
        echo "This page should only be access after redirection back from the wiki.";
        exit( 1 );
    }

    // Configure the OAuth client with the URL and consumer details.
    $conf = new ClientConfig( env('MW_OAUTH_URL') );
    $conf->setConsumer( new Consumer(env('MW_OAUTH_KEY'), env('MW_OAUTH_SECRET') ) );
    $conf->setUserAgent( 'DemoApp MediaWikiOAuthClient/1.0' );
    $client = new Client( $conf );

    session_start();
    $requestToken = new Token( $_SESSION['request_key'], $_SESSION['request_secret'] );

    // Send an HTTP request to the wiki to retrieve an Access Token.
    $accessToken = $client->complete( $requestToken,  $_GET['oauth_verifier'] );

    // At this point, the user is authenticated, and the access token can be used to make authenticated
    // API requests to the wiki. You can store the Access Token in the session or other secure
    // user-specific storage and re-use it for future requests.
    $_SESSION['access_key'] = $accessToken->key;
    $_SESSION['access_secret'] = $accessToken->secret;

    // You also no longer need the Request Token.
    unset( $_SESSION['request_key'], $_SESSION['request_secret'] );

    return view('logged-in');
});

Route::get('/home', function () {
    // Make the api.php URL from the OAuth URL.
    $apiUrl = preg_replace( '/index\.php.*/', 'api.php', env('MW_OAUTH_URL') );

    // Configure the OAuth client with the URL and consumer details.
    $conf = new ClientConfig( env('MW_OAUTH_URL') );
    $conf->setConsumer( new Consumer(env('MW_OAUTH_KEY'), env('MW_OAUTH_SECRET') ) );
    $conf->setUserAgent( 'DemoApp MediaWikiOAuthClient/1.0' );
    $client = new Client( $conf );

    // Load the Access Token from the session.
        session_start();
        $accessToken = new Token( $_SESSION['access_key'], $_SESSION['access_secret'] );

    // Example 1: get the authenticated user's identity.
        $ident = $client->identify( $accessToken );
        echo "You are authenticated as $ident->username.\n\n";

    // Example 2: do a simple API call.
        $userInfo = json_decode( $client->makeOAuthCall(
            $accessToken,
            "$apiUrl?action=query&meta=userinfo&uiprop=rights&format=json"
        ) );
    echo "== User info ==\n\n";
    print_r( $userInfo );

    // return view('logged-in');
});

Route::get('/logout', function () {
    session_start();
    session_destroy();

    echo "You are now logged out. <a href='/'>Log in.</a>";
});
