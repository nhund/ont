<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 13:08
 */

namespace App\Components\Auth;

use App\Helpers\Helper;
use App\Models\Auth\AccessTokenEntity;
use App\Models\Auth\PassportClient;
use App\Transformers\Auth\AccessTokenEntityFull;
use App\Transformers\Auth\PersonalAccessTokenFull;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Laravel\Passport\PersonalAccessTokenResult;

class Authenticator
{

    use ClientRetrieval;

    /**
     * Issue access and refresh tokens using password grant with provided oauth client.
     *
     * @param PassportClient $client
     * @param $username
     * @param $password
     * @param string $scope
     * @return AccessTokenEntity|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function issueTokensUsingPasswordGrantWithClient(PassportClient $client, $username, $password, $scope = '')
    {
        $scope = $this->formatScope($scope);

        $request = request()->create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $username,
            'password' => $password,
//            'scope' => $scope,
        ]);

        return $this->handleTokenRequest($request);
    }

    /**
     * @param $grantType
     * @param $clientId
     * @param $clientSecret
     * @param $username
     * @param $password
     * @param string $scope
     * @return AccessTokenEntity
     * @throws \Exception
     */
    public function issueTokensUsingPasswordGrant($grantType, $clientId, $clientSecret, $username, $password, $scope = '')
    {

        $client = $this->retrieveClient($clientId);

        if ($client->secret !== $clientSecret) {
            throw new ModelNotFoundException('The provided client credentials are invalid.');
        }

        $request = request()->create('/oauth/token', 'POST', [
            'grant_type' => $grantType,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $username,
            'password' => $password,
            'scope' => $scope,
        ]);

        return $this->handleTokenRequest($request);

    }

    /**
     * Issue access and refresh tokens using a given refresh token.
     *
     * @param $clientId
     * @param $refreshToken
     * @param string $scope
     * @return AccessTokenEntity|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function issueTokensFormRefreshToken($clientId, $refreshToken, $scope = '')
    {
        $client = $this->retrieveClient($clientId);
        $scope  = $this->formatScope($scope);

        $request = request()->create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => $scope,
        ]);

        return $this->handleTokenRequest($request);
    }

    /**
     * Issue access and refresh tokens using social grant.
     *
     * @param $clientId
     * @param $clientSecret
     * @param $socialToken
     * @param $socialProvider
     * @param string $scope
     * @return AccessTokenEntity|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function issueTokensUsingSocialGrant($clientId, $clientSecret, $socialToken, $socialProvider, $scope = '')
    {
        $client = $this->retrieveClient($clientId);
        $scope = $this->formatScope($scope);

        if ($client->secret !== $clientSecret) {
            throw new ModelNotFoundException('The provided client credentials are invalid.');
        }

        $request = request()->create('/oauth/token', 'POST', [
            'grant_type' => 'social',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'token' => $socialToken,
            'provider' => $socialProvider,
            'scope' => $scope,
        ]);

        return $this->handleTokenRequest($request);
    }

    /**
     * Format a given scope string.
     *
     * @param  string|mixed $value
     * @return string
     */
    protected function formatScope($value)
    {
        if (empty($value) || !is_string($value)) {
            return '';
        }

        $segments = explode(',', $value);

        if (count($segments) === 1) {
            return trim($segments[0]);
        }

        return trim(implode(' ', $segments));
    }

    /**
     * Handle custom token request.
     *
     * @param $request
     * @return AccessTokenEntity|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    protected function handleTokenRequest($request)
    {
        $response = app()->handle($request);

        if (!($response instanceof Response && $response->status() >= 200 && $response->status() < 300)) {
            return $response;
        }

        $tokens = Helper::decode_json_payload(
            (string) $response->getContent(),
            new ErrorException(__('Unable to process token response. The authentication process failed.'))
        );

        $this->refreshSession($request);

        if (Arr::has($tokens, 'errors') || !Arr::has($tokens, 'access_token')) {
            return $response;
        }
        dd($response, 222);

        return AccessTokenEntity::newInstance($tokens);
    }

    /**
     * Refresh the request session and the current session.
     *
     * @param  \Illuminate\Http\Request|null $request
     * @return void
     */
    protected function refreshSession($request = null)
    {
        $request = $request ?? app('request');

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerate();
        }

        auth()->guard()->logout();
        session()->invalidate();
        session()->regenerate();
    }

    public function respondWithTokens(Request $request, $tokenEntity)
    {
        if ($tokenEntity instanceof JsonResponse) {
            return $tokenEntity;
        }

        if ($tokenEntity instanceof PersonalAccessTokenResult){
            return fractal()
                ->item($tokenEntity)
                ->transformWith(new PersonalAccessTokenFull)
                ->respond();
        }

        if (!($tokenEntity instanceof AccessTokenEntity)) {
            return $tokenEntity;
        }

        return fractal()
            ->item($tokenEntity)
            ->transformWith(new AccessTokenEntityFull)
            ->respond();
    }
}