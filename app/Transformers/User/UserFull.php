<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 16:20
 */

namespace App\Transformers\User;

use App\Transformers\SchoolTransformer;
use App\User;
use League\Fractal\TransformerAbstract;

class UserFull extends TransformerAbstract
{

    protected $defaultIncludes =['school'];

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

    public function includeSchool(User $user){

        return $user->school ? $this->item($user->school, new SchoolTransformer) : null;
    }
}