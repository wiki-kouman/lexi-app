<?php

use App\Services\MediawikiAPIService;
use App\Services\OAuthService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', function () {
    if(OAuthService::isLoggedIn()){
        return redirect('home');
    }
    return view('logged-out');
});

Route::get('/login', function () {
    // Configure the OAuth client with the URL and consumer details.
    $client = OAuthService::getClient();
    list( $oauthUrl, $token ) = $client->initiate();
    OAuthService::addRequestTokenToSession($token);

    return redirect($oauthUrl);
});

Route::get('/oauth-callback', function () {
    if ( !isset( $_GET['oauth_verifier'] ) ) {
        echo "This page should only be access after redirection back from the wiki.";
        exit( 1 );
    }

    // Configure the OAuth client with the URL and consumer details.
    $client = OAuthService::getClient();
    $requestToken = OAuthService::getRequestToken();

    // Send an HTTP request to the wiki to retrieve an Access Token.
    $accessToken = $client->complete( $requestToken,  $_GET['oauth_verifier'] );
    OAuthService::addAccessTokenToSession($accessToken);

    return redirect('/home');
});

Route::get('/home', function () {
    $client = OAuthService::getClient();
    $accessToken = OAuthService::getAccessToken();

    $mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
    $user = $mediawikiAPIService->getUserInfo();
    $user = $user->query->userinfo;
    return view('logged-in', compact('user'));
});

Route::get('/logout', function () {
    OAuthService::clearSession();
    return redirect('/');
});
