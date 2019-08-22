<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 13:53
 */

namespace App\Transformers\Auth;

use App\Models\Auth\AccessTokenEntity;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class AccessTokenEntityFull extends TransformerAbstract
{

    /**
     * The user associated with the access token.
     *
     * @var \App\User
     */
    protected $user;

    protected $availableIncludes=['user'];

    /**
     * @param AccessTokenEntity $entity
     * @return array
     */
    public function transform(AccessTokenEntity $entity){

        $this->user = $entity->getUser();
        $data = [
            'token_type'    => $entity->getType(),
            'access_token'  => $entity->getAccessToken(),
            'refresh_token' => $entity->getRefreshToken(),
            'expires_in'    => $entity->getExpiresIn(),
        ];

        return $data;
    }

    /**
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser()
    {
        return $this->user ? $this->item($this->user, new UserFull) : null;
    }
}