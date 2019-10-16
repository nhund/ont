<?php

namespace App\Transformers\Lesson;

use App\Components\User\UserCourseReportService;
use App\Models\CommentCourse;
use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class LessonTransformer extends TransformerAbstract {

    protected $availableIncludes = ['subLesson'];

    protected $lesson;

    /**
     * @param Lesson $lesson
     * @return array
     */
    public function transform(Lesson $lesson){
        $this->lesson = $lesson;

        $subLesson =  (new UserCourseReportService(request()->user(), null))->subLessons($lesson);

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
            'parent_id' => $lesson->parent_id,
            'subLesson' => $subLesson
        ];
    }
}