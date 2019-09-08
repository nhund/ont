<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 16:20
 */

namespace App\Transformers\User;

use App\User;
use League\Fractal\TransformerAbstract;

class UserFull extends TransformerAbstract
{

    public function transform(User $user){
        return [
            'id'        =>$user->id,
            'name'      => $user->name,
            'full_name' => $user->full_name,
            'email'     => $user->email,
            'phone'     => $user->phone,
            'gender'    => $user->gender,
            'avatar'    => $user->avatar,
        ];
    }
}