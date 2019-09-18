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
            'full_name' => $user->name_full,
            'email'     => $user->email,
            'phone'     => $user->phone,
            'gender'    => $user->gender,
            'avatar_full'    => $user->avatar_full,
        ];
    }
}