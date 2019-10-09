<?php

namespace App\Transformers\Exam;

use App\Models\ExamUser;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class ExamUserTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user'];

    public function transform(ExamUser $examUser)
    {

        return [
            'id' => $examUser->id,
            'user_id' => $examUser->user_id,
            'score' => $examUser->score,
            'turn' => $examUser->turn,
            'exam_id' => $examUser->exam_id,
        ];

    }

    public function includeUser(ExamUser $examUser)
    {
        $user = $examUser->user;

        return $user ? $this->item($user, new UserFull) : null;

    }
}