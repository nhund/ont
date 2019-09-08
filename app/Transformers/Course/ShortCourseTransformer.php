<?php

namespace App\Transformers\Course;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class ShortCourseTransformer extends TransformerAbstract
{
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
            'avatar'      => $course->avatar,
            'price'       => $course->price,
            'study_time'  => $course->study_time,
            'discount'    => $course->discount,
            'category_id' => $course->category_id,
            'description' => $course->description,
            'avatar_paht' => $course->avatar_paht,
            'status'      => $course->status,
            'sticky'      => $course->sticky,
        ];
    }
}
