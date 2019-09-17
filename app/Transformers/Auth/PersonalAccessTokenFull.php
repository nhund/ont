<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 13:53
 */

namespace App\Transformers\Auth;

use App\Models\Auth\AccessTokenEntity;
use App\Models\Auth\PassportToken;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class PersonalAccessTokenFull extends TransformerAbstract
{

    /**
     * The user associated with the access token.
     *
     * @var \App\User
     */
    protected $user;

    protected $availableIncludes = ['user'];

    protected $defaultIncludes =['user'];

    /**
     * @param $entity
     * @return array
     */
    public function transform($entity){

        $data = [
            'access_token'  => $entity->accessToken,
//            'refresh_token' => '',
//            'expires_in'    => '',
            'token_type'    => 'Bearer',
        ];

        return $data;
    }

    /**
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser($entity)
    {

        $tokenInstance = PassportToken::parseToken($entity->accessToken);

        return $tokenInstance ? $this->item($tokenInstance->user, new UserFull) : null;
    }
}