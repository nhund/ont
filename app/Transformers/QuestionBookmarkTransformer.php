<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:04
 */

namespace App\Transformers;

use App\Models\Slide;
use App\Models\UserQuestionBookmark;
use League\Fractal\TransformerAbstract;

class QuestionBookmarkTransformer extends TransformerAbstract
{

    public function transform(UserQuestionBookmark $bookmark)
    {
        return [
            'id'        => $bookmark->id,
            'user_id'   => $bookmark->user_id,
            'course_id' => $bookmark->course_id,
            'lesson_id' => $bookmark->lesson_id,
            'status'    => $bookmark->status,
        ];
    }
}