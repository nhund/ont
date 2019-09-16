<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 16/09/2019
 * Time: 16:25
 */

namespace App\Http\Controllers\Api\Auth\Social;


use App\Components\Auth\Authenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialAuthenticationRequest;

class SocialController extends Controller
{
    /**
     * Perform social authentication using the given social provider.
     *
     * @param SocialAuthenticationRequest $request
     * @param $provider
     * @return mixed
     * @throws \Exception
     */
    public function authenticate(SocialAuthenticationRequest $request, $provider)
    {
        $mobileClient = $request->mobileClient();
        $clientId = $mobileClient === 'web' ? config('auth.web_app_client.id') : $request->input('client_id');
        $clientSecret = $mobileClient === 'web' ? config('auth.web_app_client.secret') : $request->input('client_secret');

//        $authCode = $request->input('auth_code');
//        $oldGoogleClientId = config('services.google.client_id');
//        $oldGoogleClientSecret = config('services.google.client_secret');
        $accessToken = null;
//        if ($authCode) {
//            config([
//                       'services.google.client_id' => config('services.google.client_id_google_sign_in'),
//                       'services.google.client_secret' => config('services.google.client_secret_google_sign_in'),
//                   ]);
//            $accessToken = ($authCode) ? \Socialite::driver($provider)->getAccessTokenResponse($authCode) : null;
//            if ($accessToken) $accessToken = $accessToken['access_token'];
//            else {
//                config([
//                           'services.google.client_id' => $oldGoogleClientId,
//                           'services.google.client_secret' => $oldGoogleClientSecret,
//                       ]);
//            }
//        }

        $accessToken = $accessToken ?? $request->input('token');

        $tokenEntity = (new Authenticator())->issueTokensUsingSocialGrant(
            $clientId,
            $clientSecret,
            $accessToken,
            $provider
        );

        return (new Authenticator())->respondWithTokens($request, $tokenEntity);
    }
}