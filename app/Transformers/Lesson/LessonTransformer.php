<?php

namespace App\Transformers\Lesson;

use App\Models\CommentCourse;
use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class LessonTransformer extends TransformerAbstract {
    
    public function transform(Lesson $lesson){

        return [
            'id'          => $lesson->id,
            'name'        => $lesson->name,
            'description' => $lesson->description,
            'created_at'  => $lesson->created_at,
            'is_exercise' => $lesson->is_exercise,
            'image'       => $lesson->image,
        ];
    }
}