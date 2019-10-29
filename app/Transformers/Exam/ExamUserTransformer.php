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

        $doingTime  = (strtotime($examUser->last_at) - strtotime($examUser->begin_at) - $examUser->second_stop)/60;

        return [
            'id' => $examUser->id,
            'user_id' => $examUser->user_id,
            'score' => $examUser->highest_score,
            'turn' => $examUser->turn,
            'exam_id' => $examUser->lesson_id,
            'doing_time' => $doingTime,
            'unit' => 'phút'
        ];

    }

    public function includeUser(ExamUser $examUser)
    {
        $user = $examUser->user;

        return $user ? $this->item($user, new UserFull) : null;

    }
}