<?php

namespace App\Transformers\Lesson;

use App\Models\CommentCourse;
use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class LessonQuestionTransformer extends TransformerAbstract {

    protected $defaultIncludes = ['question'];

    protected $lesson;

    /**
     * @param Lesson $lesson
     * @return array
     */
    public function transform(Lesson $lesson){
        $this->lesson = $lesson;

        return [
            'id'          => $lesson->id,
            'name'        => $lesson->name,
            'description' => $lesson->description,
            'description_format' => strip_tags($lesson->description),
            'created_at'  => $lesson->created_at,
            'is_exercise' => $lesson->is_exercise,
            'image'       => $lesson->image,
            'sapo'        => $lesson->sapo,
            'repeat_time' => $lesson->repeat_time,
            'parent_id' => $lesson->parent_id
        ];
    }

    /**
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeSubLesson()
    {
       $subLessons =  $this->lesson->subLesson()->active()->get();
       return $subLessons ? $this->collection($subLessons, new FullLessonTransformer) : null;
    }
}