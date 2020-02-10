<?php

namespace App\Models\Auth;

use Illuminate\Support\Arr;

class AccessTokenEntity
{
    /**
     * The access token string.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * The refresh token string.
     *
     * @var string
     */
    protected $refreshToken;

    /**
     * The expiration time.
     *
     * @var integer
     */
    protected $expiresIn;

    /**
     * The token type.
     *
     * @var string
     */
    protected $type;

    /**
     * @param string $accessToken
     * @param string $refreshToken
     * @param integer $expiresIn
     * @param string $type
     */
    public function __construct($accessToken, $refreshToken, $expiresIn, $type = 'Bearer')
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->expiresIn = $expiresIn;
        $this->type = $type;
    }

    /**
     * @return \App\Models\User|null
     */
    public function getUser()
    {
        $tokenInstance = PassportToken::parseToken($this->getAccessToken());

        if (is_null($tokenInstance)) {
            return null;
        }

        return $tokenInstance->user;
    }

    /**
     * Create new access token entity instance.
     *
     * @param  array $data
     * @return static
     */
    public static function newInstance(array $data)
    {
        return new static(
            Arr::get($data, 'access_token'),
            Arr::get($data, 'refresh_token'),
            Arr::get($data, 'expires_in')
        );
    }


    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
