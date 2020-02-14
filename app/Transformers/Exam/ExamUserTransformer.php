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
            'id'             => $examUser->id,
            'user_id'        => $examUser->user_id,
            'score'          => $examUser->highest_score,
            'turn'           => $examUser->turn,
            'exam_id'        => $examUser->lesson_id,
            'status_stop'    => $examUser->status_stop,
            'doing_time'     => $examUser->doing_time,
            'still_time'     => $examUser->still_time,
            'turn_stop'      => $examUser->turn_stop,
            'highest_score'  => $examUser->highest_score,
            'last_submit_at' => $examUser->last_submit_at,
            'status'         => $examUser->status,
            'unit'           => 'phút',
            'stand_score'    => $examUser->exam->min_score
        ];

    }

    public function includeUser(ExamUser $examUser)
    {
        $user = $examUser->user;

        return $user ? $this->item($user, new UserFull) : null;

    }
}