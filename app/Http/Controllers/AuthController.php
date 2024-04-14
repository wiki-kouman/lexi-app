<?php

	namespace App\Http\Controllers;

    use App\OAuthClient\Exception;
    use App\Services\MediawikiAPIService;
    use App\Services\OAuthService;
    use Illuminate\Routing\Redirector;
    use Illuminate\View\View;

    class AuthController extends Controller
	{
        private OAuthService $service;

        public function home (): View | Redirector {
            if(OAuthService::isLoggedIn()){
                return redirect('home');
            }
            return view('/home/logged-out');
        }

        /**
         * @throws Exception
         */
        public function login(): View | Redirector{
            // Configure the OAuth client with the URL and consumer details.
            $client = OAuthService::getClient();
            list( $oauthUrl, $token ) = $client->initiate();
            OAuthService::addRequestTokenToSession($token);

            return redirect($oauthUrl);
        }

        public function callback() : null | Redirector{
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
        }

        /**
         * @throws Exception
         */
        public function loggedout(): View {
            $client = OAuthService::getClient();
            $accessToken = OAuthService::getAccessToken();

            $mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
            $user = $mediawikiAPIService->getUserInfo();
            $user = $user->query->userinfo;
            return view('/home/logged-in', compact('user'));
        }

        public function logout (): Redirector {
            OAuthService::clearSession();
            return redirect('/');
        }

        public function about(): View {
            return view('about');
        }
    }