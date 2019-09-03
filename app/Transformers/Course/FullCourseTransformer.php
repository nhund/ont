<?php

namespace App\Transformers\Course;

use App\Models\Course;
use League\Fractal\TransformerAbstract;
use App\Transformers\Comment\CommentTransformer;

class FullCourseTransformer extends TransformerAbstract
{
    protected $availableIncludes =['comment', 'lesson'];

    protected $course;
    /**
     * A Fractal transformer Course.
     *
     * @param Course $course
     * @return array
     */
    public function transform(Course $course)
    {
        $this->course = $course;
        return [
            'id'          => $course->id,
            'name'        => $course->name,
            'avatar'      => $course->avatar,
            'price'       => $course->price,
            'study_time'  => $course->study_time,
            'discount'    => $course->discount,
            'category_id' => $course->category_id,
            'description' => $course->description,
            'avatar_paht' => $course->avatar_paht,
            'status'      => $course->status,
            'sticky'      => $course->sticky,
            'rating_1'      => $course->rating_1,
            'rating_2'      => $course->rating_2,
            'rating_3'      => $course->rating_3,
            'rating_4'      => $course->rating_4,
            'rating_5'      => $course->rating_5,
        ];
    }

    public function includeComment(){
        $comments =  $this->course->comment;

        return $comments ?  $this->collection($comments,  new CommentTransformer) : null;
    }
}
