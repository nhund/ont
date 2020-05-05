<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:47
 */

namespace App\Transformers\Exam;


use App\Models\Question;
use League\Fractal\TransformerAbstract;

class ShortExamTransformer extends TransformerAbstract
{

    public function transform(Question $question)
    {

        return [
            'id' => $question->id,
            'content' => $question->content,
            'img_before' => $question->img_before,
            'img_after' => $question->img_after,
            'parent_id' => $question->parent_id,
            'lesson_id' => $question->lesson_id,
            'user_id' => $question->user_id,
            'explain_before' => $question->explain_before,
            'explain_after' => $question->explain_after,
            'question' => $question->question,
            'question_after' => $question->question_after,
            'course_id' => $question->course_id,
            'audio_content' => $question->audio_content,
            'audio_explain_before' => $question->audio_explain_before,
            'audio_explain_after' => $question->audio_explain_after,
            'audio_question' => $question->audio_question,
            'audio_question_after' => $question->audio_question_after,
            'order_s' => $question->order_s,
            'interpret' => $question->interpret,
            'interpret_all' => $question->interpret_all,
        ];

    }
}