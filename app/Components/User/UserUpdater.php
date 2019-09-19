<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 19/09/2019
 * Time: 15:43
 */

namespace App\Components\User;

use App\User;

class UserUpdater
{
    /**
     * updating info of user
     *
     * @param User $user
     * @param $params
     * @return User
     */
    public function update(User $user, $params)
    {
        $attributes = $this->transformAttributes($params);
        $user->update($attributes);
        return $user->refresh();
    }


    /**
     * refactor params request
     *
     * @param  array $attributes
     * @return array
     */
    protected function transformAttributes(array $attributes)
    {
        $map = [
            'name',
            'full_name',
            'phone',
            'gender',
            'birthday',
            'status',
            'avatar',
            'level',
            'school_id',
            'user_group',
            'status',
        ];

        foreach ($attributes as $dbKey => $key) {
            if (!in_array($dbKey, $map)){
                unset($attributes[$dbKey]);
            }
        }

        return $attributes;
    }
}