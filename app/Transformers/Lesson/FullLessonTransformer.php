<?php

namespace App\Transformers\Lesson;

use App\Models\CommentCourse;
use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class FullLessonTransformer extends TransformerAbstract {

    protected $lesson;

    public function transform(Lesson $lesson){
        $this->lesson = $lesson;

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