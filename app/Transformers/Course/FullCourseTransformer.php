<?php

namespace App\Transformers\Course;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Transformers\Lesson\LessonTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\Comment\CommentTransformer;
use phpDocumentor\Reflection\Types\Self_;

class FullCourseTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['comment'];

    protected $defaultIncludes = ['lesson'];

    const BOUGHT = 1;
    const NOT_YET_BUY = 2;
    const EXPIRED = 3;


    /**
     * A Fractal transformer Course.
     *
     * @param Course $course
     * @return array
     */
    public function transform(Course $course)
    {
        return [
            'id'          => $course->id,
            'name'        => $course->name,
            'price'       => $course->price,
            'study_time'  => $course->study_time,
            'discount'    => $course->discount,
            'category_id' => $course->category_id,
            'description' => $course->description,
            'description_format' => strip_tags($course->description),
            'avatar_thumb' => $course->avatar_thumb,
            'status'      => $course->status,
            'sticky'      => $course->sticky,
            'rating_1'      => $course->rating_1,
            'rating_2'      => $course->rating_2,
            'rating_3'      => $course->rating_3,
            'rating_4'      => $course->rating_4,
            'rating_5'      => $course->rating_5,
            'status_user_course' => $this->checkStatusUser($course)
        ];
    }

    public function includeComment(Course $course){
        $comments =  $course->comment;

        return $comments ?  $this->collection($comments,  new CommentTransformer) : null;
    }

    public function includeLesson(Course $course){
        $lessons =  $course->lesson()->where('parent_id', Lesson::PARENT_ID)->get();

        return $lessons ?  $this->collection($lessons,  new LessonTransformer) : null;
    }

    /**
     *
     * check status user access the website
     *
     * @param Course $course
     * @return int
     */
    public function checkStatusUser(Course $course)
    {
        $userId = request()->get('user_id');

        $userCourse = $course->userCourse()->where('user_id', $userId)->first();

        if (empty($userCourse) || $userCourse->status == UserCourse::STATUS_OFF){
            return self::NOT_YET_BUY;
        }

        if ($userCourse->and_date < time()){
            return self::EXPIRED;
        }

        return self::BOUGHT;
    }
}
