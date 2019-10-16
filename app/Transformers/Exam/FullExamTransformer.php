<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:47
 */

namespace App\Transformers\Exam;


use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class FullExamTransformer extends TransformerAbstract
{
    public function transform(Lesson $lesson)
    {
        return [
            'id'          => $lesson->id,
            'name'        => $lesson->name,
            'description' => $lesson->description,
            'description_format' => strip_tags($lesson->description),
            'is_exercise' => $lesson->is_exercise,
            'image'       => $lesson->image,
            'sapo'        => $lesson->sapo,
            'repeat_time' => $lesson->repeat_time,
            'parent_id' => $lesson->parent_id
        ];
    }
}