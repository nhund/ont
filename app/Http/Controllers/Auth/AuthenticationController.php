<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 17:07
 */

namespace App\Http\Controllers\Auth;


use App\Components\Auth\Authenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefreshTokenRequest;

class AuthenticationController extends Controller
{
    protected $authenticator;
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Generate access token from a given refresh token.
     *
     * @param  \App\Http\Requests\RefreshTokenRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function refreshAccessToken(RefreshTokenRequest $request)
    {
        $tokenEntity = $this->authenticator->issueTokensFormRefreshToken(
            $request->input('client_id'),
            $request->input('refresh_token'),
            $request->input('scope')
        );

        return $this->authenticator->respondWithTokens($request, $tokenEntity);
    }
}