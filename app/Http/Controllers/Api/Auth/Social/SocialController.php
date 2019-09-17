<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 16/09/2019
 * Time: 16:25
 */

namespace App\Http\Controllers\Api\Auth\Social;

use App\Components\Auth\Authenticator;
use App\Components\Auth\Social\SocialService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialAuthenticationRequest;
use App\User;

class SocialController extends Controller
{
    protected $socialService;

    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

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
        $user = null;

        if ($provider == SocialService::FACEBOOK)
        {
            $user = $this->socialService
                    ->refactorFields($request->all())
                    ->findOrCreateUser(User::LOGIN_FB);

        }

        if ($provider == SocialService::GOOGLE)
        {
            $user = $this->socialService
                    ->refactorFields($request->all())
                    ->findOrCreateUser(User::LOGIN_GG);
        }

        if ($user){
            $tokenEntity = $user->createToken($provider);
            return (new Authenticator())->respondWithTokens($request, $tokenEntity);

        }

        return $this->respondNotFound("the {$provider} is invalid");

    }
}