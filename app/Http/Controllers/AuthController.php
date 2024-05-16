<?php

	namespace App\Http\Controllers;

	use App\OAuthClient\Exception;
	use App\Services\MediawikiAPIService;
	use App\Services\OAuthService;
	use Illuminate\Http\RedirectResponse;
	use Illuminate\Routing\Redirector;
	use Illuminate\View\View;

    class AuthController extends Controller
	{

        private string $MESSAGE_ERROR = 'An error occured while trying to login. Please try again.';

        public function home(): View | RedirectResponse {
            if(OAuthService::isLoggedIn()){
                return redirect('home');
            }
            return view('/home/logged-out');
        }

        /**
         * @throws Exception
         */
        public function login(): View | RedirectResponse{
            // Configure the OAuth client with the URL and consumer details.
            $client = OAuthService::getClient();
			$this->clearSessionInputs();
			list( $oauthUrl, $token ) = $client->initiate();
            OAuthService::addRequestTokenToSession($token);

            return redirect($oauthUrl);
        }

        public function callback() : View | RedirectResponse{
            if ( !isset( $_GET['oauth_verifier'] ) ) {
                echo "This page should only be access after redirection back from the wiki.";
                exit( 1 );
            }

            try{
                // Configure the OAuth client with the URL and consumer details.
                $client = OAuthService::getClient();
                $requestToken = OAuthService::getRequestToken();

                // Send an HTTP request to the wiki to retrieve an Access Token.
                $accessToken = $client->complete( $requestToken,  $_GET['oauth_verifier'] );
                OAuthService::addAccessTokenToSession($accessToken);
                return redirect('/home');

            } catch (Exception $exception){
                $message = $this->MESSAGE_ERROR;
                return view('messages/error', compact('message'));
            }

        }

        /**
         * @throws Exception
         */
        public function loggedIn(): View {
			$client = OAuthService::getClient();
			$accessToken = OAuthService::getAccessToken();

			$mediawikiAPIService = new MediawikiAPIService($client, $accessToken);
			$user = $mediawikiAPIService->getUserInfo();

			return view('/home/logged-in', compact('user'));
        }

        public function logout (): RedirectResponse|Redirector {
            OAuthService::clearSession();
			$this->clearSessionInputs();
            return redirect('/');
        }

        public function about(): View {
            return view('about');
        }
    }
